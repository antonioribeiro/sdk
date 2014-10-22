<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

class AddGroupCommand {

	public $user;

	public $name;

	public $members;

	function __construct($user, $name, $members)
	{
		$this->user = $user;

		$this->name = $name;

		$this->members = $members;
	}

}
