<?php

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.Sdk.Services.Connect.Events.UserWasInvited', function($event)
{
	$repo = new UserRepository();

	$repo->sendInvitationEmail($event->user);
});

Event::listen('PragmaRX.Sdk.Services.Connect.Events.UserAcceptedInvitation', function($event)
{
	$repo = new UserRepository();

	$inviterId = $event->user->inviter ? $event->user->inviter->id : null;

	if ($inviterId)
	{
		// Establish a connection between the users
		$repo->connect($event->user->username, $event->user->inviter->id, true);
	}

	// Send a password reminder to the new user
	$user = $repo->sendPasswordReminder($event->user);

	$repo->dispatchEventsFor($user);
});
