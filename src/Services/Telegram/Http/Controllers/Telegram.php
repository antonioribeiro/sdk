<?php

namespace PragmaRX\Sdk\Services\Telegram\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Products\Data\Repositories\Telegram as TelegramRepository;

class Telegram extends BaseController
{
    /**
     * @var TelegramRepository
     */
    private $repository;

    public function __construct(Request $request, TelegramRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

	public function handleWebhook($robot, $token)
	{
        $this->repository->receive($robot, $token, $this->request->all());

        return $this->success();
	}
}
