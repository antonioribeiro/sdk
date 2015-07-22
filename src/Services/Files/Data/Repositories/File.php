<?php

namespace PragmaRX\Sdk\Services\Files\Data\Repositories;

use Config;
use Exception;
use File as Filesystem;
use Guzzle\Http\Client;
use PragmaRX\Sdk\Services\Users\Data\Entities\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use PragmaRX\Sdk\Services\Files\Exceptions\UploadPathNotSet;
use PragmaRX\Sdk\Services\Files\Data\Entities\File as FileModel;
use PragmaRX\Sdk\Services\Files\Data\Entities\Directory as DirectoryModel;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName as FileNameModel;
use PragmaRX\Sdk\Services\Users\Data\Entities\UserFile as UserFileModel;

class File
{
	private $guzzle;

	public function upload(UploadedFile $uploaded, User $user)
	{
		return $this->uploadUserFile($uploaded, $user, false);
	}

	public function uploadUserFile(UploadedFile $uploaded, User $user, $returnUserFile = true)
	{
		$hash = $this->makeFileHash($uploaded);

		$originalName = $uploaded->getClientOriginalName();

		if ($file = FileModel::where('hash', $hash)->first())
		{
			return $returnUserFile
					? $this->findUserFile($user, $file, $originalName)
					: $file;
		}

		$file = $this->uploadFile($uploaded, $hash);

		$userFile = $this->findUserFile($user, $file, $originalName);

		if ($returnUserFile)
		{
			return $userFile;
		}

		return $file;
	}

	private function getRelativePath()
	{
		if ( ! $path = Config::get('app.upload_relative_path'))
		{
			throw new UploadPathNotSet(
				'You must set the upload path in config/app.php.'
			);
		}

		return $path;
	}

	private function getRootPath()
	{
		if ( ! $path = Config::get('app.upload_root'))
		{
			throw new UploadPathNotSet('You must set the upload root in config/app.php.');
		}

		return $path;
	}

	private function findUserFile($user, $file, $originalName)
	{
		$fileName = FileNameModel::firstOrCreate([
			'file_id' => $file->id,
			'name' => $originalName
		]);

		return UserFileModel::firstOrCreate([
			'file_name_id' => $fileName->id,
			'user_id' => $user->id
		]);
	}

	public function downloadFile($url)
	{
		$pathInfo = pathinfo($url);

		$tempname = $this->download($url);

		return $this->uploadFile(
			new UploadedFile(
				$tempname,
				$this->cleanBaseName($pathInfo['basename']),
				null,
				null,
				null,
				true // Test mode
			)
		);
	}

	/**
	 * @param UploadedFile $uploaded
	 * @return mixed
	 */
	private function makeFileHash(UploadedFile $uploaded)
	{
		return Filesystem::hash($uploaded->getPathname());
	}

	/**
	 * @param UploadedFile $uploaded
	 * @param $hash
	 * @return static
	 */
	private function createFile(UploadedFile $uploaded, $hash)
	{
		$uploadFullPath = $this->getRootPath() . '/' . $this->getRelativePath();

		list($uploaded, $deepPath) = Filesystem::moveUploadedFile($uploaded, $uploadFullPath, $hash);

		$directory = DirectoryModel::firstOrCreate(
			[
				'path' => $this->getRootPath(),
				'relative_path' => $this->getRelativePath()
			]
		);

		$file = FileModel::create(
			[
				'directory_id' => $directory->id,
				'deep_path' => $deepPath,
				'hash' => $hash,
				'size' => $uploaded->getSize(),
				'extension' => $uploaded->getExtension(),
				'image' => starts_with($uploaded->getMimeType(), 'image/'),
			]
		);

		return $file;
	}

	public function uploadFile(UploadedFile $uploaded)
	{
		$hash = $this->makeFileHash($uploaded);

		if ( ! $file = FileModel::where('hash', $hash)->first())
		{
			$file = $this->createFile($uploaded, $hash);
		}

		return FileNameModel::firstOrCreate([
			'file_id' => $file->id,
			'name' => $uploaded->getClientOriginalName()
		]);
	}

	private function cleanBaseName($basename)
	{
		$pos = strpos($basename, '?');

		if ($pos !== false)
		{
			$basename = substr($basename, 0, $pos);
		}

		return $basename;
	}

	private function download($url)
	{
		$tempname = tempnam(sys_get_temp_dir(), 'tmpfile_');

		$cmd = "wget -q \"$url\" -O $tempname";

		@exec($cmd);

		return $tempname;
	}

	public function guzzle()
	{
		if ( ! $this->guzzle)
		{
			$this->guzzle = new Client();
		}

		return $this->guzzle;
	}
}
