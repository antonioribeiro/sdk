<?php

namespace PragmaRX\Sdk\Services\Login\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class Login extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $rules = [
			'email' => 'required|email|exists:users,email',
			'password' => 'required',
		];
	}

}
