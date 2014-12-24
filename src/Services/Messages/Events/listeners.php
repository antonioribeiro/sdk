<?php

Event::listen('PragmaRX.Sdk.Services.Messages.Events.MessageWasSent', function($event)
{
	$repository = app()->make('PragmaRX\Sdk\Services\Messages\Data\Repositories\Message');

	$repository->pushSentMessageNotifications($event, Auth::user());
});
