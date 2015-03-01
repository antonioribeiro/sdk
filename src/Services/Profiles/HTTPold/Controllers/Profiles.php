<?php

namespace PragmaRX\Sdk\Services\Profiles\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Kinds\Data\Entities\Kind;
use PragmaRX\Sdk\Services\Kinds\Data\Repositories\KindRepository;
use PragmaRX\Sdk\Services\Profiles\Commands\EditProfileCommand;
use PragmaRX\Sdk\Services\Statuses\Data\Repositories\StatusRepository;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Services\Profiles\Forms\Edit as EditForm;
use PragmaRX\Sdk\Services\Profiles\Http\Requests\UpdateProfile;

use View;
use Auth;
use Input;
use Flash;
use Redirect;

class Profiles extends BaseController {

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

	public function edit(KindRepository $kindRespository, $username)
	{
		return View::make('profiles.edit')
				->with('user', Auth::user())
				->with('kinds', $kindRespository->allForSelect());
	}

	public function update(UpdateProfile $request)
	{
		$user = $this->execute(EditProfileCommand::class);

		Flash::message(t('paragraphs.profile-updated'));

		return Redirect::route('profile.edit', [$user->username]);
	}

}
