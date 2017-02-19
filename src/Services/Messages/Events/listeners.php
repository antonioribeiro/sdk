<?php

use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message;

Event::listen('PragmaRX.Sdk.Services.Messages.Events.MessageWasSent', function($event)
{
	$repository = app(Message::class);

	$repository->pushSentMessageNotifications($event, Auth::user());
});
