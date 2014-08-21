<?php

namespace PragmaRX\SDK\Services\Files\File;

use Illuminate\Filesystem\Filesystem;
use App;

class Service {

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

}
