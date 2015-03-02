<?php

namespace PragmaRX\Sdk\Services\Statuses\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class PostStatus extends FormRequest {

	public function rules()
	{
		return [
			'body' => 'required',
		];
	}

}
