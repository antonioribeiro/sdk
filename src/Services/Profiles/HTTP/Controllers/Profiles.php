<?php

namespace PragmaRX\SDK\Services\Profiles\HTTP\Controllers;

use Laracasts\Commander\Events\DispatchableTrait;
use PragmaRX\SDK\Core\Controller as BaseController;
use PragmaRX\SDK\Services\Statuses\Data\Repositories\StatusRepository;
use PragmaRX\SDK\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\SDK\Services\Profiles\Forms\Edit as EditForm;

use View;
use Auth;
use Input;
use Flash;
use Redirect;

class Profiles extends BaseController {

	use DispatchableTrait;

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var StatusRepository
	 */
	private $statusRepository;

	/**
	 * @var EditForm
	 */
	private $editForm;

	function __construct(UserRepository $userRepository, StatusRepository $statusRepository, EditForm $editForm)
	{
		$this->userRepository = $userRepository;

		$this->statusRepository = $statusRepository;

		$this->editForm = $editForm;

		$this->beforeFilter('auth');
	}

	public function show($username)
	{
		if (Auth::user())
		{
			$statuses = $this->statusRepository->getFeedForUser(Auth::user());
		}
		else
		{
			$statuses = $this->statusRepository->getAll();
		}

		$user = $this->userRepository->getProfile($username);

		$this->dispatchEventsFor($user);

		return View::make('profiles.show')->with(compact('user', 'statuses'));
	}

	public function edit()
	{
		return View::make('profiles.edit')
				->with('user', Auth::user());
	}

	public function update()
	{
		$this->validateForUpdate();

		$this->execute(EditProfileCommand::class);

		Flash::message(t('paragraphs.profile-updated'));

		return Redirect::back();
	}

	private function validateForUpdate()
	{
		$this->editForm->validate(
			Input::all(),
			['username' => 'unique:users,username,'.Auth::user()->id]
		);
	}
}