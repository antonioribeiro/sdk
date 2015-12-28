<?php

namespace PragmaRX\Sdk\Services\Users\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Users\Data\Entities\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SendUserActivationEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param  User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param UserRepository $userRepository
     */
    public function handle(UserRepository $userRepository)
    {
        $userRepository->sendUserActivationEmail($this->user);
    }
}
