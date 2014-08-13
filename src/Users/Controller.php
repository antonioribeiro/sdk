<?php

namespace PragmaRX\SDK\Users;

use View;
use PragmaRX\SDK\Core\Controller as BaseController;

class Controller extends BaseController {

	/**
	 * @param UserRepository $userRepository
	 */
	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;

		$this->beforeFilter('auth');
	}

	public function index()
	{
		$users = $this->userRepository->getPaginated();

		return View::make('users.index')->with(compact('users'));
	}

}
