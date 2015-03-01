<?php

namespace PragmaRX\Sdk\Services\Passwords\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;
use Validator;

class ResetPassword extends FormRequest {

	private $rules;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		Validator::replacer('exists', function($message, $attribute, $rule, $parameters)
		{
			return t('paragraphs.invalid-password-token');
		});

		return [
			'token' => 'exists:reminders,code'
		];
	}

}
