<?php

namespace PragmaRX\Sdk\Services\Language\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use Language as LanguageService;

use Redirect;

class Language extends BaseController {

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function change($locale)
	{
		LanguageService::changeLocale($locale);

		return Redirect::back();
	}

}
