<?php

use PragmaRX\SDK\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.SDK.Services.Profiles.Events.ProfileVisited', function($event)
{
	$repo = new UserRepository();

	$repo->registerVisitation($event->user);
});
