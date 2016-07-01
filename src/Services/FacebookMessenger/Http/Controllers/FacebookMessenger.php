<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Repositories\FacebookMessenger as FacebookMessengerRepository;

class FacebookMessenger extends BaseController
{
    /**
     * @var FacebookMessengerRepository
     */
    private $repository;

    public function __construct(Request $request)
    {
        $this->request = $request;
        
        $this->repository = app(FacebookMessengerRepository::class);
    }

    public function verifyBot($robot, $token)
    {
        \Log::info('Facebook - Verifying hub token');
        \Log::info('Facebook - hub_mode: '.$this->request->get('hub_mode'));
        \Log::info('Facebook - hub_challenge: '.$this->request->get('hub_challenge'));
        \Log::info('Facebook - hub_verify_token: '.$this->request->get('hub_verify_token'));

        if (config('env.FACEBOOK_HUB_VERIFY_TOKEN') !== $this->request->get('hub_verify_token'))
        {
            abort(403);
        }

        return response($this->request->get('hub_challenge'));
    }
    
	public function handleWebhook($robot, $token)
	{
        $this->repository->receive($robot, $token, $this->request);

        return $this->success();
	}
}
