<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

class AddMembersToGroupCommand {

	public $user;

	public $group_id;

	public $members;

	function __construct($user, $group_id, $members)
	{
		$this->user = $user;

		$this->group_id = $group_id;

		$this->members = $members;
	}

}
