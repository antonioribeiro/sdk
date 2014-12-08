<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;


class MoveMessagesCommand {

	public $user;

	public $folder_id;

	public $threads_ids;

	function __construct($folder_id, $threads_ids, $user)
	{
		$this->folder_id = $folder_id;

		$this->threads_ids = $threads_ids;

		$this->user = $user;
	}

}
