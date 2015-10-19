<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Users\Data\Contracts\UserRepository;

class Users extends BaseController
{
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function index()
	{
		$users = $this->userRepository->allWithBusiness();

		return view('businesses.users.index')->with('users', $users);
	}

	public function create()
	{
		return view('businesses.users.create');
	}
}
