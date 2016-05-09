<?php

namespace PragmaRX\Sdk\Services\Users\Providers;

use PragmaRX\Sdk\Services\Users\Events\UserGotOnline;
use PragmaRX\Sdk\Services\Users\Events\UserWentOffline;
use PragmaRX\Sdk\Services\Users\Listeners\BroadcastUserIsOnline;
use PragmaRX\Sdk\Services\Users\Listeners\BroadcastUserIsOffline;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class Event extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
        UserGotOnline::class => [
            BroadcastUserIsOnline::class,
        ],

        UserWentOffline::class => [
            BroadcastUserIsOffline::class,
        ],
	];
}
