<?php

namespace PragmaRX\Sdk\Services\Files\Commands;


class UploadFileCommand {

	public $file;

	public $user;

	function __construct($file, $user)
	{
		$this->file = $file;

		$this->user = $user;
	}

}
