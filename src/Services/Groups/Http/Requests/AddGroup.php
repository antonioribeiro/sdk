<?php

namespace PragmaRX\Sdk\Services\Groups\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;
use Auth;

class AddGroup extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required|unique:groups,name,NULL,id,owner_id,'.Auth::user()->id
		];
	}

	public function messages()
	{
		return [
			'unique' => t('paragraphs.you-already-have-this-group')
		];
	}

}
