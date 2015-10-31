<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class CreateUser extends FormRequest
{
	public function rules()
	{
		return [
			'first_name' => 'required',
			'last_name' => 'required',
			'business_client_id' => 'required',
			'email' => 'required|email',
		    'business_role_id' => 'required',
		];
	}
}
