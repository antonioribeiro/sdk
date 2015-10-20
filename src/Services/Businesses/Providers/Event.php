<?php

namespace PragmaRX\Sdk\Services\Businesses\Providers;

use PragmaRX\Sdk\Services\Businesses\Events\UserWasCreated;
use PragmaRX\Sdk\Services\Businesses\Listeners\SendWelcomeEmail;
use PragmaRX\Sdk\Services\Businesses\Listeners\SendPasswordReminder;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class Event extends ServiceProvider
{
	protected $listen = [
		UserWasCreated::class => [
			SendWelcomeEmail::class,
			SendPasswordReminder::class,
		],
	];
}
