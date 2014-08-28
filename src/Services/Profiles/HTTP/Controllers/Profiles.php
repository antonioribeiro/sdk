<?php

namespace PragmaRX\Sdk\Services\Profiles\Http\Controllers;

use Laracasts\Commander\Events\DispatchableTrait;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Kinds\Data\Entities\Kind;
use PragmaRX\Sdk\Services\Profiles\Commands\EditProfileCommand;
use PragmaRX\Sdk\Services\Statuses\Data\Repositories\StatusRepository;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Services\Profiles\Forms\Edit as EditForm;

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
		$kinds = Kind::lists('name', 'id');

		$kinds = [0 => "Contact Type"] + $kinds;

		return View::make('profiles.edit')
				->with('user', Auth::user())
				->with('kinds', $kinds);
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
