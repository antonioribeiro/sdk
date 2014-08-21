<?php

use PragmaRX\SDK\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.SDK.Services.Registration.Events.UserRegistered', function($event)
{
	$repo = new UserRepository();

	$repo->checkAndCreateActivation($event->user);
});
