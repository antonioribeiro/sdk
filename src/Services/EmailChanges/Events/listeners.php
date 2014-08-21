<?php

use PragmaRX\SDK\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.SDK.Services.EmailChanges.Events.EmailChangeRequested', function($event)
{
	$repo = new UserRepository();

	$repo->sendEmailChangeEmail($event->data);
});
