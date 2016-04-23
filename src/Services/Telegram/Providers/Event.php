<?php

namespace PragmaRX\Sdk\Services\Telegram\Providers;

use PragmaRX\Sdk\Services\Telegram\Events\TelegramPhotoWasCreated;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramUserWasCreated;
use PragmaRX\Sdk\Services\Telegram\Listeners\BroadcastLoggedOutUser;
use PragmaRX\Sdk\Services\Telegram\Listeners\DownloadTelegramPhoto;
use PragmaRX\Sdk\Services\Telegram\Listeners\DownloadUserProfilePhotos;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class Event extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
        TelegramUserWasCreated::class => [
            DownloadUserProfilePhotos::class,
        ],

        TelegramPhotoWasCreated::class => [
            DownloadTelegramPhoto::class,
        ],
	];
}
