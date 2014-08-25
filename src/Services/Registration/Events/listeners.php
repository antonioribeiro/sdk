<?php

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.Sdk.Services.Registration.Events.UserRegistered', function($event)
{
	$repo = new UserRepository();

	$repo->checkAndCreateActivation($event->user);
});
