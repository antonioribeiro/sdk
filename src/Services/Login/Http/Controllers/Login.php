<?php

namespace PragmaRX\Sdk\Services\Login\Http\Controllers;

use View;
use Auth;
use Flash;
use Redirect;
use Sentinel;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Accounts\Jobs\SignIn;
use PragmaRX\Sdk\Services\Accounts\Jobs\SignOut;
use PragmaRX\Sdk\Services\Login\Forms\SignIn as SignInForm;
use PragmaRX\Sdk\Services\Login\Http\Requests\Login as LoginRequest;

class Login extends BaseController
{
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
	public function store(LoginRequest $request)
	{
		$input = [
			'email' => $request->get('email') ,
			'password' => $request->get('password'),
			'remember' => $request->get('remember') ?: false,
		];

		return $this->login($input);
	}

	public function destroy()
	{
        dispatch(new SignOut());

		Flash::message(t('paragraphs.you-are-logged-out'));

		return Redirect::home();
	}

	public function fast($email, $password, $remember = null)
	{
		Auth::logout();

		$input = compact('email', 'password', 'remember');

		return $this->login($input);
	}

	private function login($input)
	{
		$result = dispatch(new SignIn($input['email'], $input['password'], $input['remember']));

		if ($result['next'] == 'two-factor')
		{
			return Redirect::route('login.twofactor')->with('user', $result['user'])->withInput();
		}

		Flash::message(t('paragraphs.welcome-back'));

		return Redirect::intended('/');
	}
}
