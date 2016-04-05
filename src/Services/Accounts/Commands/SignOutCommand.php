<?php

namespace PragmaRX\Sdk\Services\Accounts\Commands;

use Auth;
use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SignOutCommand extends SelfHandlingCommand
{
    public function handle(UserRepository $userRepository)
    {
        $user = Auth::user();

        $result = $userRepository->logout($user);

        $this->dispatchEventsFor($user);

        return $result;
    }
}
