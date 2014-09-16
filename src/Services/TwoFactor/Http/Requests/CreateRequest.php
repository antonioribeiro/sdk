<?php namespace PragmaRX\Sdk\Services\TwoFactor\Http\Requests;

use Carbon\Carbon;
use PragmaRX\Sdk\Core\Validation\FormRequest;

use PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidRequest;
use PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidToken;
use PragmaRX\Sdk\Services\TwoFactor\Exceptions\TokenExpired;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use Session;
use Flash;

class CreateRequest extends FormRequest {

	public function rules()
	{
		return [];
	}

	public function authorize(UserRepository $repository)
	{
		if ( ! $user = Session::get('user'))
		{
			throw new InvalidRequest();
		}

		$databaseUser = $repository->findById($user->id);

		$repository->validateTwoFactorToken($databaseUser, $user->two_factor_token);

		return true;
	}

}
