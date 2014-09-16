<?php

namespace PragmaRX\Sdk\Services\Security\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Core\Redirect;
use PragmaRX\Sdk\Services\TwoFactor\Data\Entities\TwoFactorType;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use View;
use Auth;

class Security extends BaseController {

	public function edit()
	{
		$selectTwoFactor = TwoFactorType::lists('name', 'id');

		return View::make('security.edit')
				->with('user', Auth::user())
				->with('selectTwoFactor', $selectTwoFactor);
	}

}
