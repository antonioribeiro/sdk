<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

class DeleteGroupMembersCommand {

	public $user;

	public $group_id;

	public $members;

	public $administrators;

	function __construct($administrators, $group_id, $members, $user)
	{
		$this->administrators = $administrators;

		$this->group_id = $group_id;

		$this->members = $members;

		$this->user = $user;
	}

}
