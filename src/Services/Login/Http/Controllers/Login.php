<?php

namespace PragmaRX\Sdk\Services\Login\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Accounts\Commands\SignInCommand;
use PragmaRX\Sdk\Services\Login\Forms\SignIn as SignInForm;

use View;
use Input;
use Auth;
use Sentinel;
use Flash;
use Redirect;

class Login extends BaseController {

	/**
	 * @var SignInForm
	 */
	private $signInForm;

	/**
	 * @param SignInForm $signInForm
	 */
	public function __construct(SignInForm $signInForm)
	{
		$this->beforeFilter('guest', ['except' => 'destroy']);

		$this->signInForm = $signInForm;
	}

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
	public function store($email = null, $password = null, $remember = null)
	{
		$input = [
			'email' => $email ?: Input::get('email'),
			'password' => $password ?: Input::get('password'),
			'remember' => $remember ?: Input::get('remember') === 'on',
		];

		$this->signInForm->validate($input);

		$result = $this->execute(SignInCommand::class, $input);

		if ($result['next'] == 'two-factor')
		{
			return Redirect::route('login.twofactor')->with('user', $result['user']);
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
