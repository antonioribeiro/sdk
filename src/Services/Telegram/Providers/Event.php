<?php

namespace PragmaRX\Sdk\Services\Telegram\Providers;

use PragmaRX\Sdk\Services\Telegram\Events\TelegramUserWasCreated;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramAudioWasCreated;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramPhotoWasCreated;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramVideoWasCreated;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramVoiceWasCreated;
use PragmaRX\Sdk\Services\Telegram\Listeners\DownloadTelegramVideo;
use PragmaRX\Sdk\Services\Telegram\Listeners\DownloadTelegramVoice;
use PragmaRX\Sdk\Services\Telegram\Listeners\DownloadTelegramAudio;
use PragmaRX\Sdk\Services\Telegram\Listeners\DownloadTelegramPhoto;
use PragmaRX\Sdk\Services\Telegram\Listeners\BroadcastLoggedOutUser;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramDocumentWasCreated;
use PragmaRX\Sdk\Services\Telegram\Listeners\DownloadTelegramDocument;
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

        TelegramDocumentWasCreated::class => [
            DownloadTelegramDocument::class,
        ],

        TelegramAudioWasCreated::class => [
            DownloadTelegramAudio::class,
        ],

        TelegramVoiceWasCreated::class => [
            DownloadTelegramVoice::class,
        ],

        TelegramVideoWasCreated::class => [
            DownloadTelegramVideo::class,
        ],
	];
}
