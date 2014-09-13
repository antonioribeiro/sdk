<?php

namespace PragmaRX\Sdk\Services\Profiles\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

use View;
use Auth;
use Input;
use Flash;
use Redirect;

class EmailChanges extends BaseController {

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function change($token)
	{
		dd($token);

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

}
