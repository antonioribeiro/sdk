<?php

namespace PragmaRX\Sdk\Services\Files\Service;

use Symfony\Component\Finder\Finder;
use Illuminate\Filesystem\Filesystem;
use App;

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
		// $fileName = $this->getFileName($file);
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

}
