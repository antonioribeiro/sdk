<?php

namespace PragmaRX\SDK\Login;

use Illuminate\Support\Facades\Redirect;
use PragmaRX\SDK\Accounts\SignInCommand;
use PragmaRX\SDK\Core\Controller as BaseController;
use PragmaRX\SDK\Login\Forms\SignIn as SignInForm;

use View;
use Input;
use Auth;
use Sentinel;
use Session;
use Flash;

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

		return Redirect::intended('/');
	}

	public function destroy()
	{
		Flash::message(t('paragraphs.you-are-logged-out'));

		Auth::logout();

		return Redirect::home();
	}
}
