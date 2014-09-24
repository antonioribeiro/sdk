<?php namespace PragmaRX\Sdk\Services\Security\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;
use PragmaRX\Sdk\Services\Security\Exceptions\InvalidCode;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

use Auth;

class GoogleCodeRequest extends FormRequest {

	public function rules()
	{
		return [
			'google_authenticator_code' => 'required',
		];
	}

	public function afterValidate(UserRepository $repository)
	{
		$repository->verifyGoogleCode(Auth::user(), $this->get('google_authenticator_code'));
	}

}
