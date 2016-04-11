<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Controllers;

use Gate;
use Flash;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Telegram\Service\Telegram as TelegramService;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class Telegram extends BaseController
{
	/**
	 * @var BusinessesRepository
	 */
	private $businessesRepository;
    /**
     * @var TelegramService
     */
    private $telegramService;

    public function __construct(BusinessesRepository $businessesRepository, TelegramService $telegramService)
	{
		$this->businessesRepository = $businessesRepository;
        $this->telegramService = $telegramService;
    }

	public function setWebhook($businessId, $clientId)
	{
		if (Gate::denies('create', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

        $client = $this->businessesRepository->findClientById($clientId);

        $client->telegram_bot_webhook_url = $this->telegramService->getWebhookUrl($client->telegram_bot_name, $client->telegram_bot_token);

        $client->save();

        $message = $this->telegramService->setWebhook($client->telegram_bot_name, $client->telegram_bot_token);

        Flash::message($message);

        return redirect()->back();
	}
}
