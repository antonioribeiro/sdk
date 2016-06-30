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
        return response($this->request->get('hub_challenge'));
    }
    
	public function handleWebhook($robot, $token)
	{
        $this->repository->receive($robot, $token, $this->request);

        return $this->success();
	}
}
