<?php

namespace PragmaRX\SDK\Services\Login\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use PragmaRX\SDK\Core\Controller as BaseController;
use PragmaRX\SDK\Services\Accounts\Commands\SignInCommand;
use PragmaRX\SDK\Services\Login\Forms\SignIn as SignInForm;

use View;
use Input;
use Auth;
use Sentinel;
use Flash;

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
	public function store()
	{
		$input = Input::only('email', 'password');

		$this->signInForm->validate($input);

		$this->execute(SignInCommand::class, $input);

		Flash::message(t('paragraphs.welcome-back'));

		return Redirect::intended('/');
	}

	public function destroy()
	{
		Flash::message(t('paragraphs.you-are-logged-out'));

		Auth::logout();

		return Redirect::home();
	}
}
