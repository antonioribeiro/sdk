<?php

namespace PragmaRX\Sdk\Services\Settings\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class Update extends FormRequest {

	private $rules;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return ['client_field_name' => 'required'];
	}

}
