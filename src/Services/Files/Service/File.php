<?php

namespace PragmaRX\Sdk\Services\Files\Service;

use Symfony\Component\Finder\Finder;
use Illuminate\Filesystem\Filesystem;
use App;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File {

	/**
	 * @var Filesystem
	 */
	private $filesystem;

	public function __construct()
	{
		$this->filesystem = App::make('files');
	}

	public function upload($file)
	{
		return $file;
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(
			array($this->filesystem, $name),
			$arguments
		);
	}

	public function allDirectories($directory)
	{
		$directories = [];

		foreach (Finder::create()->in($directory)->directories() as $dir)
		{
			$directories[] = $dir;
		}

		return $directories;
	}

	public function tempDir()
	{
		$name = 'tempfolder';
		$counter = 0;

		while(file_exists($directory = sys_get_temp_dir()."/{$name}_{$counter}"))
		{
			$counter++;
		}

		mkdir($directory);

		return $directory;
	}

	public function hash($file)
	{
		return sha1_file($file);
	}

	public function moveUploadedFile(UploadedFile $file, $path, $hash)
	{
		$extension = $file->getClientOriginalExtension();

		$deepPath = $this->makeDeepPath($hash);

		$hashPath = $path . $deepPath;

		$fileName = "{$hash}.{$extension}";

		$this->makeUploadDirectory($hashPath, 0775, true); // true = recursive

		$file = $file->move($hashPath, $fileName);

		return [$file, $deepPath];
	}

	private function makeDeepPath($string)
	{
		$path = '';

		for ($x = 0; $x <= min(6, strlen($string)); $x++)
		{
			$path .= '/'.$string[$x];
		}

		return $path;
	}

	private function makeUploadDirectory($hashPath, $int, $true)
	{
		if ( ! $this->exists($hashPath))
		{
			$this->makeDirectory($hashPath, 0775, true); // true = recursive
		}
	}

}
