<?php

namespace PragmaRX\Sdk\Services\Profiles\Http\Controllers;

use View;
use Auth;
use Flash;
use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Profiles\Jobs\EditProfileJob;
use PragmaRX\Sdk\Services\Profiles\Http\Requests\UpdateProfile;
use PragmaRX\Sdk\Services\Kinds\Data\Repositories\KindRepository;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Services\Statuses\Data\Repositories\StatusRepository;


class Profiles extends BaseController
{
	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var StatusRepository
	 */
	private $statusRepository;

	function __construct(UserRepository $userRepository, StatusRepository $statusRepository)
	{
		$this->userRepository = $userRepository;

		$this->statusRepository = $statusRepository;
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
		$user = dispatch(new EditProfileJob());

		Flash::message(t('paragraphs.profile-updated'));

		return Redirect::route('profile.edit', [$user->username]);
	}
}
