<?php

namespace PragmaRX\Sdk\Services\Connect\Providers;

use PragmaRX\Sdk\Services\Connect\Events\UserWasInvited;
use PragmaRX\Sdk\Services\Connect\Events\UserAcceptedInvitation;
use PragmaRX\Sdk\Services\Connect\Listeners\SendInvitationEmail;
use PragmaRX\Sdk\Services\Connect\Listeners\ConnectAndSendPasswordReminder;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class Event extends ServiceProvider {

	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		UserWasInvited::class => [
			SendInvitationEmail::class,
		],

		UserAcceptedInvitation::class => [
			ConnectAndSendPasswordReminder::class,
		],
	];

}
