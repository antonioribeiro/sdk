<?php

namespace PragmaRX\Sdk\Services\Chat\Providers;

use PragmaRX\Sdk\Services\Chat\Events\ChatWasRead;
use PragmaRX\Sdk\Services\Chat\Events\ChatWasCreated;
use PragmaRX\Sdk\Services\Chat\Events\ChatWasResponded;
use PragmaRX\Sdk\Services\Chat\Events\ChatWasTerminated;
use PragmaRX\Sdk\Services\Chat\Listeners\NotifyChatRead;
use PragmaRX\Sdk\Services\Chat\Events\ChatUserCheckedIn;
use PragmaRX\Sdk\Services\Login\Events\UserWasLoggedOut;
use PragmaRX\Sdk\Services\Chat\Events\ChatUserCheckedOut;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageWasSent;
use PragmaRX\Sdk\Services\Chat\Listeners\NotifyChatCreated;
use PragmaRX\Sdk\Services\Login\Events\UserWasAuthenticated;
use PragmaRX\Sdk\Services\Chat\Listeners\NotifyChatResponded;
use PragmaRX\Sdk\Services\Chat\Listeners\BroadcastLoggedUser;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageWasDelivered;
use PragmaRX\Sdk\Services\Chat\Listeners\NotifyChatTerminated;
use PragmaRX\Sdk\Services\Chat\Listeners\NotifyChatMessageSent;
use PragmaRX\Sdk\Services\Chat\Listeners\NotifyMessageDelivery;
use PragmaRX\Sdk\Services\Chat\Listeners\BroadcastLoggedOutUser;
use PragmaRX\Sdk\Services\Chat\Listeners\NotifyChatUserCheckedIn;
use PragmaRX\Sdk\Services\Chat\Listeners\NotifyChatUserCheckedOut;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramMessageReceived;
use PragmaRX\Sdk\Services\Chat\Listeners\TransferTelegramMessageToChat;
use PragmaRX\Sdk\Services\Chat\Listeners\TransferFacebookMessengerMessageToChat;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerMessageReceived;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class Event extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
        UserWasAuthenticated::class => [
            BroadcastLoggedUser::class,
		],

        UserWasLoggedOut::class => [
            BroadcastLoggedOutUser::class,
        ],

        TelegramMessageReceived::class => [
            TransferTelegramMessageToChat::class,
        ],

        FacebookMessengerMessageReceived::class => [
            TransferFacebookMessengerMessageToChat::class,
        ],
        
        ChatWasCreated::class => [
            NotifyChatCreated::class,
        ],

        ChatMessageWasSent::class => [
            NotifyChatMessageSent::class,
        ],

        ChatWasResponded::class => [
            NotifyChatResponded::class,
        ],

        ChatWasRead::class => [
            NotifyChatRead::class,
        ],

        ChatWasTerminated::class => [
            NotifyChatTerminated::class,
        ],

        ChatUserCheckedIn::class => [
            NotifyChatUserCheckedIn::class,
        ],

        ChatUserCheckedOut::class => [
            NotifyChatUserCheckedOut::class,
        ],

        ChatMessageWasDelivered::class => [
            NotifyMessageDelivery::class,
        ],
	];
}
