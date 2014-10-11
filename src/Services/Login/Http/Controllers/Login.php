<?php

namespace PragmaRX\Sdk\Services\Login\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Accounts\Commands\SignInCommand;
use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidPassword;
use PragmaRX\Sdk\Services\Login\Forms\SignIn as SignInForm;

use PragmaRX\Sdk\Services\Login\Http\Requests\Login as LoginRequest;

use View;
use Input;
use Auth;
use Sentinel;
use Flash;
use Redirect;

class Login extends BaseController {

	/**
	 * @return mixed
	 */
	public function create()
	{
		return View::make('login.create');
	}

	/**
	 * @return mixed
	 */
	public function store(LoginRequest $request, $email = null, $password = null, $remember = null)
	{
		$input = [
			'email' => $email ?: Input::get('email'),
			'password' => $password ?: Input::get('password'),
			'remember' => $remember ?: Input::get('remember') === 'on',
		];

		$result = $this->execute(SignInCommand::class, $input);

		if ($result['next'] == 'two-factor')
		{
			return Redirect::route('login.twofactor')->with('user', $result['user'])->withInput();
		}

		Flash::message(t('paragraphs.welcome-back'));

		return Redirect::intended('/');
	}

	public function destroy()
	{
		Flash::message(t('paragraphs.you-are-logged-out'));

		Auth::logout();

		return Redirect::home();
	}

	public function showTwoFactor()
	{
		dd('shown');
	}
}
