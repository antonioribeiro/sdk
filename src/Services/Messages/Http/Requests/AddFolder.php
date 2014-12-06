<?php

namespace PragmaRX\Sdk\Services\Messages\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;
use Auth;

class AddFolder extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'folder_name' => 'required|unique:messages_folders,name,NULL,id,user_id,'.Auth::user()->id,
		];
	}

	public function messages()
	{
		return [
			'folder_name.unique' => t('paragraphs.you-already-have-this-folder')
		];
	}

}
