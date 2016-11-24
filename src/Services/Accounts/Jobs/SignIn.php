<?php

namespace PragmaRX\Sdk\Services\Accounts\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SignIn extends Job
{
    public $email;

    public $password;

    public $remember;

    function __construct($email, $password, $remember) {
        $this->email = $email;

        $this->password = $password;

        $this->remember = $remember;
    }

    public function handle(UserRepository $userRepository) {
        $credentials = [
            'email'    => $this->email,
            'password' => $this->password,
            'remember' => $this->remember,
        ];

        return $userRepository->authenticate($credentials);
    }
}
