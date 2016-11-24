<?php

namespace PragmaRX\Sdk\Services\TwoFactor\Http\Controllers;

use View;
use Flash;
use Input;
use Redirect;
use PragmaRX\Sdk\Services\TwoFactor\Jobs\SignIn;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\TwoFactor\Http\Requests\LoginRequest;
use PragmaRX\Sdk\Services\TwoFactor\Http\Requests\CreateRequest;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class TwoFactor extends BaseController
{
	/**
	 * @return mixed
	 */
	public function create(CreateRequest $request, UserRepository $repository)
	{
		$user = $repository->getUserFromTwoFactorRequest($repository);

		return View::make('twoFactor.create')
				->with('user', $user)
				->with('remember', Input::old('remember'));
	}

	public function store(LoginRequest $request)
	{
		dispatch(new SignIn($request->all()));

		Flash::message(t('paragraphs.welcome-back'));

		return Redirect::intended('/');
	}
}
