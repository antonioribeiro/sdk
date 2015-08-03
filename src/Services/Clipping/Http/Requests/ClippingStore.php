<?php

namespace PragmaRX\Sdk\Services\Clipping\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;

class ClippingStore extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'url' => 'required|unique:clipping,url',
			'heading' => 'required',
			'published_at' => 'required|date_format:d/m/Y',
			'body' => 'required',
			'editorial_id' => 'required',
			'editorial_other' => 'required_if:editorial_id,9999',
			'locality_id' => 'required',
			'locality_other' => 'required_if:locality_id,9999',
			'vehicle_id' => 'required',
			'vehicle_other' => 'required_if:vehicle_id,9999',
		];
	}

	public function messages()
	{
		return [
			'members.required' => t('paragraphs.you-need-to-select-members')
		];
	}

}
