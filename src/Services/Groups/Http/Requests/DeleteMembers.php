<?php

namespace PragmaRX\Sdk\Services\Groups\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

use Auth;

class DeleteMembers extends FormRequest {

	public function rules()
	{
		return [
			'members' => 'required_without:administrators',
		    'administrators' => 'required_without:members'
		];
	}

	public function authorize(GroupRepository $repository)
	{
		return $repository->isGroupManager($this->get('id'), Auth::user());
	}

}
