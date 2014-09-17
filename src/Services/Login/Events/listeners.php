<?php

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.Sdk.Services.Login.Events.UserWasAuthenticated', function($event)
{
	$repo = new UserRepository();

	$repo->checkTwoFactorAuthentication($event->user);
});
