<?php

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.Sdk.Services.Passwords.Events.PasswordReminderCreated', function($event)
{
	$repo = new UserRepository();

	$repo->sendPasswordReminderEmail($event->user, $event->token);
});

Event::listen('PragmaRX.Sdk.Services.Passwords.Events.PasswordWasUpdated', function($event)
{
	$repo = new UserRepository();

	$repo->sendPasswordUpdatedEmail($event->user);
});

