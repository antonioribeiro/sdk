<?php namespace PragmaRX\Sdk\Services\TwoFactor\Http\Requests;

use Carbon\Carbon;
use PragmaRX\Sdk\Core\Validation\FormRequest;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

use Input;

class LoginRequest extends FormRequest {

	public function rules()
	{
		return [
			'user_id' => 'exists:users,id',
			'two_factor_token' => 'exists:users,two_factor_token',
		];
	}

	public function authorize(UserRepository $repository)
	{
		$user = $repository->findById(Input::get('user_id'));

		$repository->validateTwoFactorToken($user, Input::get('two_factor_token'));

		return true;
	}

}
