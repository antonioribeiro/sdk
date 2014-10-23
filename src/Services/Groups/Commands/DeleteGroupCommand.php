<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

class DeleteGroupCommand {

	public $user;

	public $group_id;

	function __construct($group_id, $user)
	{
		$this->group_id = $group_id;

		$this->user = $user;
	}

}
