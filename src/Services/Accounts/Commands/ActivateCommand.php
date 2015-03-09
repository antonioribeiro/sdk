<?php

namespace PragmaRX\Sdk\Services\Accounts\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ActivateCommand extends SelfHandlingCommand {

	public $email;

	public $token;

    public function __construct($email, $token)
    {
	    $this->email = $email;

	    $this->token = $token;
    }

	public function handle(UserRepository $userRepository)
	{
		$user = $userRepository->activate($this->email, $this->token);

	    $this->dispatchEventsFor($user);

	    return $user;
    }

}
