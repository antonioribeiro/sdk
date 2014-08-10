<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 14/07/2014
 * Time: 20:58
 */

namespace PragmaRX\SDK\Registration;

use PragmaRX\SDK\Core\Controller as BaseController;
use PragmaRX\SDK\Core\Redirect;
use PragmaRX\SDK\Registration\RegisterUserCommand;
use PragmaRX\SDK\Registration\Forms\Registration as RegistrationForm;
use View;
use Input;

class Controller extends BaseController {

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

		$this->beforeFilter('guest');
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

		$this->execute(RegisterUserCommand::class);

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
