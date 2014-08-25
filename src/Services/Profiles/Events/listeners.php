<?php

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.Sdk.Services.Profiles.Events.ProfileVisited', function($event)
{
	$repo = new UserRepository();

	$repo->registerVisitation($event->user);
});
