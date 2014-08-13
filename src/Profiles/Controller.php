<?php

namespace PragmaRX\SDK\Profiles;

use PragmaRX\SDK\Core\Controller as BaseController;
use PragmaRX\SDK\Users\UserRepository;
use View;

class Controller extends BaseController {

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;

		$this->beforeFilter('auth');
	}

	public function show($username)
	{
		$user = $this->userRepository->findByUsername($username);

		return View::make('profiles.show')->with(compact('user'));
	}

}
