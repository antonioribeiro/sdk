<?php

namespace PragmaRX\SDK\Services\Passwords\Http\Controllers;

use PragmaRX\SDK\Core\Controller as BaseController;
use Password as PasswordReminder;
use Hash;
use Input;
use Flash;
use PragmaRX\SDK\Core\Redirect;
use PragmaRX\SDK\Services\Passwords\Validators\ReminderToken as ReminderTokenValidator;
use View;

class Passwords extends BaseController {

	/**
	 * @var ReminderToken
	 */
	private $reminderTokenValidator;

	public function __construct(ReminderTokenValidator $reminderTokenValidator)
	{
		$this->reminderTokenValidator = $reminderTokenValidator;
	}

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('passwords.create');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function store()
	{
		switch ($response = PasswordReminder::remind(Input::only('email')))
		{
			case PasswordReminder::INVALID_USER:
				return Redirect::route('password')
						->with('error', t($response))
						->withInput();

			case PasswordReminder::REMINDER_SENT:
				return Redirect::route('message')
					->with('title', t('titles.reset-your-password'))
					->with('message', t('paragraphs.reset-password-sent'))
					->withInput();
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function reset($token)
	{
		Input::merge(['token' => $token]);

		$this->reminderTokenValidator->validate(['password_token' => $token]);

		return View::make('passwords.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function update()
	{
		$credentials = Input::only(
			'email',
			'password',
			'password_confirmation',
			'token'
		);

		$response = PasswordReminder::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		switch ($response)
		{
			case PasswordReminder::INVALID_PASSWORD:
			case PasswordReminder::INVALID_TOKEN:
			case PasswordReminder::INVALID_USER:
				return Redirect::back()
						->with('error', t($response))
						->withInput();

			case PasswordReminder::PASSWORD_RESET:
				Flash::message(t('paragraphs.password-was-changed'));
				return Redirect::to('/');
		}
	}

}
