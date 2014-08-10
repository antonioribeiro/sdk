<?php

namespace PragmaRX\SDK\Login;

use Illuminate\Support\Facades\Redirect;
use PragmaRX\SDK\Accounts\SignInCommand;
use Laracasts\Flash\Flash;
use View;
use PragmaRX\SDK\Core\Controller as BaseController;
use Input;
use Auth;
use PragmaRX\SDK\Login\Forms\SignIn as SignInForm;
use Sentinel;

class Controller extends BaseController {

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

		return Redirect::intended('realties');
	}

	public function destroy()
	{
		Auth::logout();

		Flash::message('You are now logged out.');

		return Redirect::home();
	}
}
