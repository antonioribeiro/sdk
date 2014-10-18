<?php

namespace PragmaRX\Sdk\Services\Clients\Commands;


class UpdateClientCommand {

	public $id;

	public $user;

	public $first_name;

	public $last_name;

	public $email;

	public $notes;

	function __construct($email, $first_name, $id, $last_name, $user, $notes)
	{
		$this->email = $email;

		$this->first_name = $first_name;

		$this->id = $id;

		$this->last_name = $last_name;

		$this->user = $user;

		$this->notes = $notes;
	}

}
