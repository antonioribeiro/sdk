<?php

namespace PragmaRX\Sdk\Services\Registration\Http\Requests;

use Config;
use PragmaRX\Sdk\Core\Validation\FormRequest;
use Validator;

class Register extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'first_name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed',
		];

		if ( ! (Config::get('app.register.username') === false))
		{
			$rules[] = ['username' => 'required|unique:users'];
		}

		return $rules;
	}

	public function beforeValidate()
	{
		Validator::replacer('unique', function($message, $attribute, $rule, $parameters)
		{
			if ($attribute == 'username')
			{
				return t('paragraphs.username-already-registered');
			}

			if ($attribute == 'email')
			{
				return t('paragraphs.email-already-registered');
			}
		});
	}
}
