<?php

namespace PragmaRX\Sdk\Services\Login\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Accounts\Commands\SignInCommand;
use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidPassword;
use PragmaRX\Sdk\Services\Login\Forms\SignIn as SignInForm;

use PragmaRX\Sdk\Services\Login\Http\Requests\Login as LoginRequest;

use View;
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
		Flash::message(t('paragraphs.you-are-logged-out'));

		Auth::logout();

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
		$result = $this->execute(SignInCommand::class, $input);

		if ($result['next'] == 'two-factor')
		{
			return Redirect::route('login.twofactor')->with('user', $result['user'])->withInput();
		}

		Flash::message(t('paragraphs.welcome-back'));

		return Redirect::intended('/');
	}

}
