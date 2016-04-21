<?php

namespace PragmaRX\Sdk\Services\Files\Data\Repositories;

use Config;
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

    private function makeExtension($uploadedFile)
    {
        if (! $extension = $uploadedFile->getExtension())
        {
            $extension = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);
        }

        return $extension;
    }

    public function upload(UploadedFile $uploaded, User $user)
	{
		return $this->uploadUserFile($uploaded, $user, false);
	}

	public function uploadFromSystemFile($file, User $user)
	{
		$uploaded = $this->createUploadedFileFromSystemFile($file);

		return $this->upload($uploaded, $user);
	}

	public function uploadUserFile(UploadedFile $uploaded, User $user, $returnUserFile = true)
	{
		$hash = $this->makeFileHash($uploaded);

		$originalName = $uploaded->getClientOriginalName();

		if ($file = FileModel::where('hash', $hash)->first())
		{
			return $returnUserFile
					? $this->findOrCreateUserFile($user, $file, $originalName)
					: $file;
		}

		$file = $this->uploadFile($uploaded);

		$userFile = $this->findOrCreateUserFile($user, $file, $originalName);

		if ($returnUserFile)
		{
			return $userFile;
		}

		return $file;
	}

	private function getRelativePath()
	{
//		if ( ! $path = Config::get('app.upload_relative_path'))
//		{
//            return 'files';
//		}
//
//		return $path;

        // All files hashed for deduplication will be inside a public/hashed folder
        return 'public/hashed';
	}

	private function getRootPath()
	{
//		if ( ! $path = Config::get('app.upload_root'))
//		{
//			throw new UploadPathNotSet('You must set upload_root directory in config/app.php.');
//		}
//
//		return $path;

        return '/';
	}

	private function findOrCreateUserFile($user, $file, $originalName)
	{
		$fileName = FileNameModel::firstOrCreate([
			'file_id' => $file->file_id,
			'name' => $originalName
		]);

		return UserFileModel::firstOrCreate([
			'file_name_id' => $fileName->id,
			'user_id' => $user->id
		]);
	}

	public function downloadFile($url, $width = null, $height = null)
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
			),
            $width,
            $height
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
	private function createFile(UploadedFile $uploaded, $hash, $width = null, $height = null)
	{
//		$uploadFullPath = $this->getRootPath() . '/' . $this->getRelativePath();

        $uploadFullPath = $this->getRelativePath();

		list($uploaded, $deepPath, $fileSize, $mimeType, $Url) = Filesystem::moveUploadedFile($uploaded, $uploadFullPath, $hash);

		$directory = DirectoryModel::firstOrCreate(
			[
                'base_url' => $Url,
				'path' => $this->getRootPath(),
				'relative_path' => $this->getRelativePath()
			]
		);

        $extension = $this->makeExtension($uploaded);

		$file = FileModel::create(
			[
				'directory_id' => $directory->id,
				'deep_path' => $deepPath,
				'hash' => $hash,
				'size' => $fileSize,
                'width' => $width,
                'height' => $height,
				'extension' => $extension,
				'image' => starts_with($mimeType, 'image/'),
			]
		);

		return $file;
	}

	public function uploadFile(UploadedFile $uploaded, $width = null, $height = null)
	{
		$hash = $this->makeFileHash($uploaded);

		if ( ! $file = FileModel::where('hash', $hash)->first())
		{
			$file = $this->createFile($uploaded, $hash, $width, $height);
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

	private function createUploadedFileFromSystemFile($file)
	{
		$temp = tempnam("/tmp", "FILE_");

		copy($file, $temp);

		$uploaded = new UploadedFile($temp, basename($file), null, null, null, true);

		return $uploaded;
	}
}
