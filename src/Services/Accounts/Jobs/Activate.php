<?php

namespace PragmaRX\Sdk\Services\Accounts\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class Activate extends Job
{
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

	    return $user;
    }
}
