<?php

namespace PragmaRX\Sdk\Services\Chat\Providers;

use PragmaRX\Sdk\Services\Login\Events\UserWasLoggedOut;
use PragmaRX\Sdk\Services\Login\Events\UserWasAuthenticated;
use PragmaRX\Sdk\Services\Chat\Listeners\BroadcastLoggedUser;
use PragmaRX\Sdk\Services\Chat\Listeners\BroadcastLoggedOutUser;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class Event extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		UserWasAuthenticated::class => [
            BroadcastLoggedUser::class,
		],

        UserWasLoggedOut::class => [
            BroadcastLoggedOutUser::class,
        ],
	];
}
