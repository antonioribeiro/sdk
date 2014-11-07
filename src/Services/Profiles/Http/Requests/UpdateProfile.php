<?php

namespace PragmaRX\Sdk\Services\Profiles\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

use Auth;

class UpdateProfile extends FormRequest {

	private $rules;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'username' => 'unique:users,username,'.Auth::user()->id
		];
	}

}
