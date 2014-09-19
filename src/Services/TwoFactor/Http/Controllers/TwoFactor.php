<?php

namespace PragmaRX\Sdk\Services\TwoFactor\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\TwoFactor\Commands\SignInCommand;
use PragmaRX\Sdk\Services\TwoFactor\Http\Requests\CreateRequest;
use PragmaRX\Sdk\Services\TwoFactor\Http\Requests\LoginRequest;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use Session;
use View;
use Flash;
use Redirect;
use Input;

class TwoFactor extends BaseController {

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
		$this->execute(SignInCommand::class);

		Flash::message(t('paragraphs.welcome-back'));

		return Redirect::intended('/');
	}

}
