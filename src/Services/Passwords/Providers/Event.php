<?php

namespace PragmaRX\Sdk\Services\Passwords\Providers;

use PragmaRX\Sdk\Services\Passwords\Events\PasswordWasUpdated;
use PragmaRX\Sdk\Services\Passwords\Events\PasswordReminderCreated;
use PragmaRX\Sdk\Services\Passwords\Listeners\SendPasswordUpdatedEmail;
use PragmaRX\Sdk\Services\Passwords\Listeners\SendPasswordReminderEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class Event extends ServiceProvider {

	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		PasswordReminderCreated::class => [
			SendPasswordReminderEmail::class,
		],

		PasswordWasUpdated::class => [
			SendPasswordUpdatedEmail::class,
		],
	];

}
