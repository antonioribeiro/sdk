<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

class UpdateGroupCommand {

	public $user;

	public $name;

	public $group_id;

	public $members;

	public $administrators;

	function __construct($administrators, $group_id, $members, $name, $user)
	{
		$this->administrators = $administrators;

		$this->group_id = $group_id;

		$this->members = $members;

		$this->name = $name;

		$this->user = $user;
	}

}

