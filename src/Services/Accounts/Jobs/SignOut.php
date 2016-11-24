<?php

namespace PragmaRX\Sdk\Services\Accounts\Jobs;

use Auth;
use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SignOut extends Job
{
    public function handle(UserRepository $userRepository)
    {
        $user = Auth::user();

        $result = $userRepository->logout($user);

        return $result;
    }
}
