<?php

namespace PragmaRX\Sdk\Services\Tags\Http\Requests;

use Auth;
use PragmaRX\Sdk\Core\Validation\FormRequest;

class UpdateClient extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'id' => 'required',
		];
	}

	public function authorize()
	{
		return Auth::user()->isProviderOf($this->get('id'));
	}

}
