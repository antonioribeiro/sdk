<?php

namespace PragmaRX\Sdk\Services\TwoFactor\Http\Requests;

use Carbon\Carbon;
use PragmaRX\Sdk\Core\Validation\FormRequest;

use PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidRequest;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

use Session;
use Input;

class CreateRequest extends FormRequest {

	public function rules()
	{
		return [];
	}

	public function authorize(UserRepository $repository)
	{
		if ( ! $user = $repository->getUserFromTwoFactorRequest($repository))
		{
			throw new InvalidRequest();
		}

		// Check against database to prevent spoof
		$databaseUser = $repository->findById($user->id);

		$repository->validateTwoFactorToken($databaseUser, 'google', $user->two_factor_google_token);

		return true;
	}

}
