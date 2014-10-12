<?php

namespace PragmaRX\Sdk\Services\Registration\Http\Controllers;

use Laracasts\Validation\FormValidationException;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Registration\Commands\RegisterUserCommand;
use PragmaRX\Sdk\Services\Registration\Forms\Registration as RegistrationForm;
use View;
use Input;
use Redirect;

class Registration extends BaseController {

	/**
	 * @var RegistrationForm
	 */
	private $registrationForm;

	/**
	 * @param RegistrationForm $registrationForm
	 */
	public function __construct(RegistrationForm $registrationForm)
	{
		$this->registrationForm = $registrationForm;
	}

	/**
	 * @return mixed
	 */
	public function create()
	{
		\Session::put('whatever', 'vvvvvv 2 vvvvv');

//		throw new FormValidationException('whatever error', []);

		return View::make('registration.create');
	}

	/**
	 * @return mixed
	 */
	public function store()
	{
		Session::put('whatever', 'value!');

		throw new FormValidationException('whatever error', []);

//		$this->registrationForm->validate(Input::all());
//
//		$input = Input::all();
//
//		$this->execute(RegisterUserCommand::class, $input);
//
//		return Redirect::route('message')
//			->with('title', t('titles.welcome'))
//			->with('message', t('paragraphs.welcome-message'))
//			->with('buttons', [[
//								'caption' => t('captions.go-to-login-page'),
//			                    'url' => route('login')
//			                   ]])
//			->withInput();
	}

}
