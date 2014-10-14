<?php

namespace PragmaRX\Sdk\Services\Registration\Http\Controllers;

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
		return View::make('registration.create');
	}

	/**
	 * @return mixed
	 */
	public function store()
	{
		$this->registrationForm->validate(Input::all());

		$input = Input::all();

		$this->execute(RegisterUserCommand::class, $input);

		return Redirect::route('message')
				->with('title', t('titles.welcome'))
				->with('message', t('paragraphs.welcome-message'))
				->with('buttons', [[
									'caption' => t('captions.go-to-login-page'),
				                    'url' => route('login')
				                   ]])
				->withInput();
	}

}
