<?php

namespace PragmaRX\Sdk\Services\Users\Http\Controllers;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use View;
use PragmaRX\Sdk\Core\Controller as BaseController;

class Users extends BaseController {

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
