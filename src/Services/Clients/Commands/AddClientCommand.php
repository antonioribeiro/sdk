<?php

namespace PragmaRX\Sdk\Services\Clients\Commands;


class AddClientCommand {

	public $user;

	public $first_name;

	public $last_name;

	public $email;

	public $mobile_phone;

	function __construct($email, $first_name, $last_name, $mobile_phone, $user)
	{
		$this->email = $email;

		$this->first_name = $first_name;

		$this->last_name = $last_name;

		$this->mobile_phone = $mobile_phone;

		$this->user = $user;
	}

}
