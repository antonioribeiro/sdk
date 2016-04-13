<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Controllers;

use Gate;
use Auth;
use Flash;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatService;
use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
use PragmaRX\Sdk\Services\Businesses\Http\Requests\UpdateService as UpdateServiceRequest;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;
use PragmaRX\Sdk\Services\Businesses\Http\Requests\CreateService as CreateServiceRequest;

class Services extends BaseController
{
	/**
	 * @var BusinessesRepository
	 */
	private $businessesRepository;

	public function __construct(BusinessesRepository $businessesRepository)
	{
		$this->businessesRepository = $businessesRepository;
	}

	public function create($businessId, $clientId)
	{
		if (Gate::denies('create', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

		return view('businesses.enterprises.clients.services.create')
				->with('businessId', $businessId)
                ->with('clientId', $clientId)
				->with('business', $this->findBusiness($businessId))
                ->with('client', $this->findClient($clientId))
                ->with('serviceTypes', ChatService::all()->pluck('name', 'id')->toArray())
                ->with('postUrl', route('businesses.clients.services.store', [$businessId, $clientId]))
				->with('cancelUrl', route('businesses.clients.edit', [$businessId, $clientId]))
				->with('cancelRouteParameters', $businessId)
				->with('submitButton', 'Criar serviço');
	}

    private function findBusiness($businessId)
    {
        return $this->businessesRepository->findById($businessId);
    }

    private function findClient($clientId)
    {
        return $this->businessesRepository->findClientById($clientId);
    }

    /**
     * @param $businessId
     * @param $clientId
     * @return mixed
     */
    private function redirectToClient($businessId, $clientId) {
        return redirect()->route('businesses.clients.edit', ['businessId' => $businessId, 'clientId' => $clientId]);
    }

    /**
     * @param $businessId
     * @param $clientId
     * @param CreateServiceRequest $createBusinessRequest
     * @return mixed
     */
    public function store($businessId, $clientId, CreateServiceRequest $createBusinessRequest)
	{
		if (Gate::denies('store', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

		$this->businessesRepository->createServiceForClient($businessId, $clientId, $createBusinessRequest->all());

		Flash::message(t('paragraphs.chat-service-created'));

        return $this->redirectToClient($businessId, $clientId);
	}

	public function edit($businessId, $clientId, $serviceId)
	{
		if (Gate::denies('edit', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

		$business = $this->businessesRepository->findById($businessId);
		$client = $this->businessesRepository->findClientById($clientId);
        $service = $this->businessesRepository->findServiceById($serviceId);

		return view('businesses.enterprises.clients.services.edit')
			->with('business', $business)
			->with('client', $client)
            ->with('service', $service)
            ->with('serviceTypes', ChatService::all()->pluck('name', 'id')->toArray())
            ->with('postUrl', route('businesses.clients.services.update', [$businessId, $clientId]))
            ->with('cancelUrl', route('businesses.clients.edit', [$businessId, $clientId]))
		;
	}

	public function update($businessId, $clientId, UpdateServiceRequest $updateBusinessRequest)
	{
		if (Gate::denies('update', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

		$this->businessesRepository->updateService($updateBusinessRequest->all());

		Flash::message(t('paragraphs.service-updated'));

        return $this->redirectToClient($businessId, $clientId);
	}

	public function delete($businessId, $clientId, $serviceId)
	{
		if (Gate::denies('delete', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

		$this->businessesRepository->deleteService($serviceId);

		Flash::message(t('paragraphs.client-deleted'));

        return $this->redirectToClient($businessId, $clientId);
    }
}
