<?php

namespace PragmaRX\Sdk\Services\Profiles\Commands;

use Illuminate\Contracts\Auth\Guard;
use PragmaRX\Sdk\Core\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class EditProfileCommand extends SelfHandlingCommand {

	public $username;

	public $email;
	
	public $first_name;

	public $last_name;

	public $bio;

	public $avatar_id;

	public $contact_information;

	function __construct(
		$username,
		$email,
		$first_name,
		$last_name,
		$bio,
		$avatar_id,
		$contact_information
	)
	{
		$this->username = $username;

		$this->email = $email;

		$this->first_name = $first_name;

		$this->last_name = $last_name;

		$this->bio = $bio;

		$this->avatar_id = $avatar_id;

		$this->contact_information = $contact_information;
	}

	public function handle(UserRepository $repository, Guard $auth)
	{
		$user = $repository->update(
			$auth->user(),
			$this->first_name,
			$this->last_name,
			$this->username,
			$this->email,
			$this->bio,
			$this->avatar_id,
			$this->contact_information
		);

		$this->dispatchEventsFor($user);

		return $user;
	}

} 
