<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class DeleteUser extends FormRequest
{
	public function rules()
	{
		return [
			'id' => 'required',
		];
	}
}
