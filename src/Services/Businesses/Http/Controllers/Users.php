<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Controllers;

use Gate;
use Auth;
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
		if (Gate::denies('viewUsers', Auth::user()))
		{
			abort(403);
		}

		$users = $this->businessesRepository->allUsers();

		return view('businesses.users.index')
			->with('users', $users)
			->with('deleteUri', '/businesses/users/delete/')
		;
	}

	public function create()
	{
		if (Gate::denies('create', Auth::user()))
		{
			abort(403);
		}

		$clients = $this->businessesRepository->allClients()->lists('name', 'id');

		$roles = $this->businessesRepository->allowedRoles();

		return view('businesses.users.create')
				->with('businessClients', $clients)
				->with('postRoute', 'businesses.users.store')
				->with('cancelRoute', 'businesses.users.index')
				->with('submitButton', 'Criar usuário')
				->with('roles', $roles->lists('description', 'id'));
	}

	public function store(CreateUserRequest $createUser)
	{
		if (Gate::denies('store', Auth::user()))
		{
			abort(403);
		}

		$this->execute(CreateUserCommand::class);

		Flash::message(t('paragraphs.user-created'));

		return Redirect::route_no_ajax('businesses.users.index');
	}

	public function edit($userId)
	{
		if (Gate::denies('edit', Auth::user()))
		{
			abort(403);
		}

		$roles = $this->businessesRepository->allowedRoles();

		$user = $this->businessesRepository->findUserById($userId);

		$user->business_role_id = $user->businessRole->id;

		$user->business_client_id = $user->present()->businessClient->id;

		$clients = $this->businessesRepository->allClients()->lists('name', 'id');

		return view('businesses.users.edit')
			->with('user', $user)
			->with('businessClients', $clients)
			->with('postRoute', 'businesses.users.update')
			->with('cancelRoute', 'businesses.users.index')
			->with('roles', $roles->lists('description', 'id'))
		;
	}

	public function update(UpdateUserRequest $updateUserRequest)
	{
		if (Gate::denies('update', Auth::user()))
		{
			abort(403);
		}

		$this->execute(UpdateUserCommand::class);

		Flash::message(t('paragraphs.user-updated'));

		return Redirect::route_no_ajax('businesses.users.index');
	}

	public function delete($userId)
	{
		if (Gate::denies('delete', Auth::user()))
		{
			abort(403);
		}

		$this->userRepository->deleteUser($userId);

		Flash::message(t('paragraphs.user-deleted'));

		return Redirect::route_no_ajax('businesses.users.index');
	}
}
