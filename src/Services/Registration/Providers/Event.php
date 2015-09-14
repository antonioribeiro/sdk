<?php

namespace PragmaRX\Sdk\Services\Registration\Providers;

use PragmaRX\Sdk\Services\Registration\Events\UserWasRegistered;
use PragmaRX\Sdk\Services\Registration\Listeners\SendActivationEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class Event extends ServiceProvider {

	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		UserWasRegistered::class => [
			SendActivationEmail::class,
		],
	];

}
