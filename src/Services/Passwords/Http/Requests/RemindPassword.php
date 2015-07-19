<?php

namespace PragmaRX\Sdk\Services\Passwords\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;
use Validator;

class RemindPassword extends FormRequest {

	private $rules;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->rules;
	}

	public function beforeValidate()
	{
		$request = $this->all();

		$email = isset($request['email']) ? $request['email'] : null;

		$username = isset($request['username']) ? $request['username'] : null;

		if ( ! $email && ! $username)
		{
			$this->rules = ['email' => 'required'];

			Validator::replacer('required', function($message, $attribute, $rule, $parameters)
			{
				return t('paragraphs.email-or-username-required');
			});

			return;
		}

		if ($email && $username)
		{
			$this->rules = ['email' => 'required'];

			Validator::replacer('required', function($message, $attribute, $rule, $parameters)
			{
				return t('paragraphs.email-or-username-required');
			});

			return;
		}

		if ($email)
		{
			$this->rules = ['email' => 'required|exists:users,email'];
		}

		if ($username)
		{
			$this->rules = ['username' => 'required|exists:users,username'];
		}
	}

}
