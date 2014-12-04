<?php

namespace PragmaRX\Sdk\Services\Messages\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class SendMessage extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'recipients' => 'required',
			'subject' => 'required',
			'body' => 'required',
		];
	}

}
