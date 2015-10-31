<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class UpdateScript extends FormRequest
{
	public function rules()
	{
		return [
			'id' => 'required',
			'name' => 'required',
			'business_client_id' => 'required',
			'chat_service_id' => 'required',
			'script' => 'required',
		    'chat_script_type_id' => 'required',
		];
	}
}
