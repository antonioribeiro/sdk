<?php

namespace PragmaRX\Sdk\Services\Language\Service;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

use App;
use Auth;
use Session;

class Language {

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function getLocale()
	{
		return App::getLocale();
	}

	public function getCountryCode()
	{
		if ($this->getLocale() == 'en')
		{
			return 'us';
		}

		return 'br';
	}

	public function getCountryName()
	{
		if ($this->getLocale() == 'en')
		{
			return 'United States';
		}

		return 'Brasil';
	}

	public function getLanguageName()
	{
		if ($this->getLocale() == 'en')
		{
			return 'English (US)';
		}

		return 'Português (brasileiro)';
	}

	public function configureLocale()
	{
		$locale = '';

		$user = Auth::user();

		if ($user && $user->locale)
		{
			$locale = $user->locale;
		}

		$locale = ($locale ?: ( Session::has('locale') ? Session::get('locale') : null ));

		$locale = $locale ?: 'pt-br';

		Session::set('locale', $locale);

		App::setLocale($locale);
	}

	public function changeLocale($locale)
	{
		if ($user = Auth::user())
		{
			$this->userRepository->changeLocale($user, $locale);
		}

		Session::put('locale', $locale);

		return $locale;
	}

}
