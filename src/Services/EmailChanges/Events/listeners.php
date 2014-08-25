<?php

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

Event::listen('PragmaRX.Sdk.Services.EmailChanges.Events.EmailChangeRequested', function($event)
{
	$repo = new UserRepository();

	$repo->sendEmailChangeEmail($event->data);
});
