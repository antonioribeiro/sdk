<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Controllers;

use Gate;
use Flash;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Businesses\Http\Requests\SetTelegramWebhookUrl;
use PragmaRX\Sdk\Services\FacebookMessenger\Service\Facade as FacebookMessengerService;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class FacebookMessenger extends BaseController
{
	/**
	 * @var BusinessesRepository
	 */
	private $businessesRepository;

    public function __construct(BusinessesRepository $businessesRepository)
	{
		$this->businessesRepository = $businessesRepository;
    }

	public function subscribe($businessId, $clientId, $serviceId)
	{
		if (Gate::denies('create', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

        $service = $this->businessesRepository->findServiceById($serviceId);

        if (! $service->bot_name || ! $service->bot_token)
        {
            Flash::message(t('paragraphs.missing-webhook-data'));

            return redirect()->back();
        }

        $result = FacebookMessengerService::subscribe($service->bot_name, $service->bot_token);

        Flash::message(t('paragraphs.webhook-configured'));

        return redirect()->back();
	}
}
