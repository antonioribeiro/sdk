<?php

namespace PragmaRX\SDK\Profiles;

use Laracasts\Commander\Events\DispatchableTrait;
use PragmaRX\SDK\Core\Controller as BaseController;
use PragmaRX\SDK\Users\UserRepository;
use View;

class Controller extends BaseController {

	use DispatchableTrait;

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;

		$this->beforeFilter('auth');
	}

	public function show($username)
	{
		$user = $this->userRepository->getProfile($username);

		$this->dispatchEventsFor($user);

		return View::make('profiles.show')->with(compact('user'));
	}

}
