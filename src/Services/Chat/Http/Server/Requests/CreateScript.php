<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class CreateScript extends FormRequest
{
	public function rules()
	{
		return [
			'name' => 'required',
			'business_client_id' => 'required',
			'chat_service_id' => 'required',
			'script' => 'required',
		];
	}
}
