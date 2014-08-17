<?php

use PragmaRX\SDK\Users\UserRepository;

Event::listen('PragmaRX.SDK.Profiles.Events.ProfileVisited', function($event)
{
	$repo = new UserRepository();

	$repo->registerVisitation($event->user);
});
