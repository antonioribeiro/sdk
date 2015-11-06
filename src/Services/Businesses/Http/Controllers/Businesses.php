<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Controllers;

use Gate;
use Auth;
use Flash;
use Redirect;
use Business as BusinessService;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\Business;
use PragmaRX\Sdk\Services\Businesses\Http\Requests\UpdateBusiness as UpdateBusinessRequest;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;
use PragmaRX\Sdk\Services\Businesses\Http\Requests\CreateBusiness as CreateBusinessRequest;

class Businesses extends BaseController
{
	/**
	 * @var BusinessesRepository
	 */
	private $businessesRepository;

	public function __construct(BusinessesRepository $businessesRepository)
	{
		$this->businessesRepository = $businessesRepository;
	}

	public function index()
	{
		if (Gate::denies('view', new Business()))
		{
			abort(403);
		}

		$businesses = $this->businessesRepository->all();

		return view('businesses.enterprises.index')
			->with('businesses', $businesses)
			->with('deleteUri', '/businesses/enterprises/delete/')
		;
	}

	public function create()
	{
		if (Gate::denies('create', new Business()))
		{
			abort(403);
		}

		return view('businesses.enterprises.create')
				->with('postRoute', 'businesses.enterprises.store')
				->with('cancelRoute', 'businesses.enterprises.index')
				->with('submitButton', 'Criar empresa');
	}

	public function store(CreateBusinessRequest $createBusinessRequest)
	{
		if (Gate::denies('store', new Business()))
		{
			abort(403);
		}

		$this->businessesRepository->createBusiness($createBusinessRequest->all());

		Flash::message(t('paragraphs.business-created'));

		return Redirect::route_no_ajax('businesses.enterprises.index');
	}

	public function edit($businessId)
	{
		if (Gate::denies('edit', new Business()))
		{
			abort(403);
		}

		$business = $this->businessesRepository->findById($businessId);

		$clients = $this->businessesRepository->addChatLinkToClients($business->clients);

		return view('businesses.enterprises.edit')
			->with('business', $business)
			->with('clients', $clients)
			->with('postRoute', 'businesses.enterprises.update')
			->with('cancelRoute', 'businesses.enterprises.index')
			->with('deleteUri', '/businesses/{businessId}/clients/{clientId}/delete/')
		;
	}

	public function update(UpdateBusinessRequest $updateBusinessRequest)
	{
		if (Gate::denies('update', new Business()))
		{
			abort(403);
		}

		$this->businessesRepository->updateBusiness($updateBusinessRequest->all());

		Flash::message(t('paragraphs.business-updated'));

		return Redirect::route_no_ajax('businesses.enterprises.index');
	}

	public function delete($businessId)
	{
		if (Gate::denies('delete', new Business()))
		{
			abort(403);
		}

		$this->businessesRepository->deleteBusiness($businessId);

		Flash::message(t('paragraphs.business-deleted'));

		return Redirect::route_no_ajax('businesses.enterprises.index');
	}

	public function select($businessId)
	{
		BusinessService::setCurrent($businessId);

		return redirect()->back();
	}

	public function selectClient($clientId)
	{
		BusinessService::setCurrentClient($clientId);

		return redirect()->back();
	}
}
