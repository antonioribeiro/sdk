<?php

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.Sdk.Services.Security.Events.TwoFactorEmailDisableRequested', function($event)
{
	$repo = new UserRepository();

	$repo->sendEmailToggleTwoFactorEmail($event->data, false);
});

Event::listen('PragmaRX.Sdk.Services.Security.Events.TwoFactorEmailEnableRequested', function($event)
{
	$repo = new UserRepository();

	$repo->sendEmailToggleTwoFactorEmail($event->data, true);
});
