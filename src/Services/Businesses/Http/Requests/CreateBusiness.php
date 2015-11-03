<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class CreateBusiness extends FormRequest
{
	public function rules()
	{
		return [
			'name' => 'required',
		];
	}
}
