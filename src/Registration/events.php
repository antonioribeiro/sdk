<?php

use PragmaRX\SDK\Users\UserRepository;

Event::listen('PragmaRX.SDK.Registration.Events.UserRegistered', function($event)
{
	$repo = new UserRepository();

	$repo->checkAndCreateActivation($event->user);
});
