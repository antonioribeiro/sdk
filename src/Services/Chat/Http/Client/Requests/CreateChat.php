<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Client\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class CreateChat extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
	public function rules()
	{
		return [
			'name' => 'required',
			'email' => 'required|email',
		];
	}
}
