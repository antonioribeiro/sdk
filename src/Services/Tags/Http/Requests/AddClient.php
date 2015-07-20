<?php

namespace PragmaRX\Sdk\Services\Tags\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class AddClient extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'first_name' => 'required',
			'email' => 'email',
//			'birthdate' => 'date',
		];
	}

}
