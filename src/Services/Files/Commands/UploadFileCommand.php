<?php

namespace PragmaRX\Sdk\Services\Files\Commands;

use PragmaRX\Sdk\Core\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Files\Data\Repositories\File as FileRepository;

class UploadFileCommand extends SelfHandlingCommand {

	public $file;

	public $user;

	function __construct($file, $user)
	{
		$this->file = $file;

		$this->user = $user;
	}

	public function handle(FileRepository $fileRepository)
	{
		return $fileRepository->upload($this->file, $this->user);
	}

}
