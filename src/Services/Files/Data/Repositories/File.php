<?php

namespace PragmaRX\Sdk\Services\Files\Repositories;

use Config;
use PragmaRX\Sdk\Services\Files\Data\Entities\File as FileModel;
use PragmaRX\Sdk\Services\Files\Data\Entities\Directory as DirectoryModel;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName as FileNameModel;
use PragmaRX\Sdk\Services\Users\Data\Entities\UserFile as UserFileModel;

use File as Filesystem;
use PragmaRX\Sdk\Services\Files\Exceptions\UploadPathNotSet;
use PragmaRX\Sdk\Services\Users\Data\Entities\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File {

	public function upload(UploadedFile $uploaded, User $user)
	{
		$hash = Filesystem::hash($uploaded->getPathname());

		if ($fileModel = FileModel::where('hash', $hash)->first())
		{
			return $fileModel;
		}

		$originalName = $uploaded->getClientOriginalName();

		$uploadFullPath = $this->getRootPath().'/'.$this->getRelativePath();

		list($uploaded, $deepPath) = Filesystem::moveUploadedFile($uploaded, $uploadFullPath, $hash);

		$directory = DirectoryModel::firstOrCreate([
			'path' => $this->getRootPath(),
			'relative_path' => $this->getRelativePath()
		]);

		$file = FileModel::create([
			'directory_id' => $directory->id,
			'deep_path' => $deepPath,
			'hash' => $hash,
		    'extension' => $uploaded->getExtension(),
		    'image' => starts_with($uploaded->getMimeType(), 'image/'),
		]);

		$fileName = FileNameModel::firstOrCreate([
			'file_id' => $file->id,
			'name' => $originalName
		]);

		UserFileModel::firstOrCreate([
	        'file_name_id' => $fileName->id,
	        'user_id' => $user->id
		]);

		return $file;
	}

	private function getRelativePath()
	{
		if ( ! $path = Config::get('app.upload_relative_path'))
		{
			throw new UploadPathNotSet('You must set the upload path in config/app.php.');
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

}
