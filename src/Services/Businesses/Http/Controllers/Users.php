<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Controllers;

use Flash;
use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Businesses\Commands\UpdateUser as UpdateUserCommand;
use PragmaRX\Sdk\Services\Businesses\Http\Requests\CreateUser as CreateUserRequest;
use PragmaRX\Sdk\Services\Businesses\Http\Requests\UpdateUser as UpdateUserRequest;
use PragmaRX\Sdk\Services\Users\Data\Contracts\UserRepository;
use \PragmaRX\Sdk\Services\Businesses\Commands\CreateUser as CreateUserCommand;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class Users extends BaseController
{
	private $userRepository;

	/**
	 * @var BusinessesRepository
	 */
	private $businessesRepository;

	public function __construct(UserRepository $userRepository, BusinessesRepository $businessesRepository)
	{
		$this->userRepository = $userRepository;
		$this->businessesRepository = $businessesRepository;
	}

	public function index()
	{
		$users = $this->userRepository->allWithBusiness();

		return view('businesses.users.index')
			->with('users', $users)
			->with('deleteUri', '/businesses/users/delete/')
		;
	}

	public function create()
	{
		$clients = $this->businessesRepository->allClients()->lists('name', 'id');

		return view('businesses.users.create')
				->with('businessClients', $clients)
				->with('postRoute', 'businesses.users.store')
				->with('cancelRoute', 'businesses.users.index')
				->with('submitButton', 'Criar usuário');
	}

	public function store(CreateUserRequest $createUser)
	{
		$this->execute(CreateUserCommand::class);

		Flash::message(t('paragraphs.user-created'));

		return Redirect::route_no_ajax('businesses.users.index');
	}

	public function edit($userId)
	{
		$user = $this->businessesRepository->findUserById($userId);

		$user->business_client_id = $user->present()->businessClient->id;

		$clients = $this->businessesRepository->allClients()->lists('name', 'id');

		return view('businesses.users.edit')
				->with('user', $user)
				->with('businessClients', $clients)
				->with('postRoute', 'businesses.users.update')
				->with('cancelRoute', 'businesses.users.index')
		;
	}

	public function update(UpdateUserRequest $updateUserRequest)
	{
		$this->execute(UpdateUserCommand::class);

		Flash::message(t('paragraphs.user-updated'));

		return Redirect::route_no_ajax('businesses.users.index');
	}

	public function delete($userId)
	{
		$this->userRepository->deleteUser($userId);

		Flash::message(t('paragraphs.user-deleted'));

		return Redirect::route_no_ajax('businesses.users.index');
	}
}
