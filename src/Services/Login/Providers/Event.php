<?php

namespace PragmaRX\Sdk\Services\Login\Providers;

use PragmaRX\Sdk\Services\Login\Events\UserWasAuthenticated;
use PragmaRX\Sdk\Services\Login\Listeners\CheckTwoFactorAuthentication;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class Event extends ServiceProvider {

	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		UserWasAuthenticated::class => [
			CheckTwoFactorAuthentication::class,
		],
	];

}
