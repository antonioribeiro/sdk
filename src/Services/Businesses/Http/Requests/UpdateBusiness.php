<?php

namespace PragmaRX\Sdk\Services\Businesses\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class UpdateBusiness extends FormRequest
{
	public function rules()
	{
		return [
			'id' => 'required',
			'name' => 'required',
		];
	}
}
