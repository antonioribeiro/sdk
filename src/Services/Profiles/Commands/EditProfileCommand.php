<?php

namespace PragmaRX\Sdk\Services\Profiles\Commands;


class EditProfileCommand {

	public $username;

	public $email;
	
	public $first_name;

	public $last_name;

	public $bio;

	function __construct(
		$username,
		$email,
		$first_name,
		$last_name,
		$bio
	)
	{
		$this->username = $username;

		$this->email = $email;

		$this->first_name = $first_name;

		$this->last_name = $last_name;

		$this->bio = $bio;
	}

} 
