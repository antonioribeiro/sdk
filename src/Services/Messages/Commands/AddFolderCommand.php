<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;


class AddFolderCommand {

	public $user;

	public $folder_name;

	function __construct($folder_name, $user)
	{
		$this->folder_name = $folder_name;

		$this->user = $user;
	}

}
