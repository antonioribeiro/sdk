<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Controllers;

use Gate;
use Auth;
use Flash;
use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
use PragmaRX\Sdk\Services\Businesses\Http\Requests\UpdateBusiness as UpdateBusinessRequest;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;
use PragmaRX\Sdk\Services\Businesses\Http\Requests\CreateBusiness as CreateBusinessRequest;

class Clients extends BaseController
{
	/**
	 * @var BusinessesRepository
	 */
	private $businessesRepository;

	public function __construct(BusinessesRepository $businessesRepository)
	{
		$this->businessesRepository = $businessesRepository;
	}

	public function create($businessId)
	{
		if (Gate::denies('create', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

		return view('businesses.enterprises.clients.create')
				->with('businessId', $businessId)
				->with('business', $this->findBusiness($businessId))
				->with('postRoute', 'businesses.clients.store')
				->with('postRouteParameters', $businessId)
				->with('cancelRoute', 'businesses.enterprises.edit')
				->with('cancelRouteParameters', $businessId)
				->with('submitButton', 'Criar cliente');
	}

	public function store($businessId, CreateBusinessRequest $createBusinessRequest)
	{
		if (Gate::denies('store', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

		$this->businessesRepository->createClientForBusiness($businessId, $createBusinessRequest['name']);

		Flash::message(t('paragraphs.client-created'));

		return redirect()->route('businesses.enterprises.edit', ['businessId' => $businessId]);
	}

	public function edit($businessId)
	{
		if (Gate::denies('edit', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

		$business = $this->businessesRepository->findById($businessId);

		$clients = $business->clients;

		return view('businesses.enterprises.edit')
			->with('business', $business)
			->with('clients', $clients)
			->with('postRoute', 'businesses.enterprises.update')
			->with('cancelRoute', 'businesses.enterprises.index')
			->with('deleteUri', '/businesses/clients/delete/')
		;
	}

	public function update($businessId, UpdateBusinessRequest $updateBusinessRequest)
	{
		if (Gate::denies('update', $this->businessesRepository->findById($businessId)))
		{
			abort(403);
		}

		$this->businessesRepository->updateBusiness($updateBusinessRequest->all());

		Flash::message(t('paragraphs.user-updated'));

		return Redirect::route_no_ajax('businesses.enterprises.index');
	}

	public function delete($businessId)
	{
		if (Gate::denies('delete', new BusinessClient()))
		{
			abort(403);
		}

		$this->businessesRepository->deleteBusiness($businessId);

		Flash::message(t('paragraphs.user-deleted'));

		return Redirect::route_no_ajax('businesses.enterprises.index');
	}

	private function findBusiness($businessId)
	{
		return $this->businessesRepository->findById($businessId);
	}
}
