<?php

namespace PragmaRX\Sdk\Services\Groups\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

use Auth;

class AddMembers extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'members' => 'required',
		];
	}

	public function messages()
	{
		return [
			'members.required' => t('paragraphs.you-need-to-select-members')
		];
	}

	public function authorize(GroupRepository $repository)
	{
		return $repository->isGroupManager($this->get('id'), Auth::user());
	}

}
