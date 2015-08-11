<?php

namespace PragmaRX\Sdk\Services\Connect\Console\Commands;

use Illuminate\Console\Command;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class Invite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:invite {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(UserRepository $userRepository)
    {
        $userRepository->inviteUsers(null, $this->argument('email'));
    }
}
