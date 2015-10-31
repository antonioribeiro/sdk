<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class UpdateUser extends FormRequest
{
	public function rules()
	{
		return [
			'id' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'business_client_id' => 'required',
			'email' => 'required|email',
		];
	}
}
