<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class CreateService extends FormRequest
{
	public function rules()
	{
		return [
			'description' => 'required',
		];
	}
}
