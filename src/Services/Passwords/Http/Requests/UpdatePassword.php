<?php

namespace PragmaRX\Sdk\Services\Passwords\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;
use Validator;

class UpdatePassword extends FormRequest {

	private $rules;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'email' => 'exists:users,email',
			'password' => 'required|confirmed',
			'token' => 'exists:password_resets,token'
		];
	}

}
