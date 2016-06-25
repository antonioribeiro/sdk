<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Providers;

use PragmaRX\Sdk\Services\Chat\Events\ChatMessageWasSent;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerUserWasCreated;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerAudioWasCreated;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerPhotoWasCreated;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerVideoWasCreated;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerVoiceWasCreated;
use PragmaRX\Sdk\Services\FacebookMessenger\Listeners\DownloadFacebookMessengerVideo;
use PragmaRX\Sdk\Services\FacebookMessenger\Listeners\DownloadFacebookMessengerVoice;
use PragmaRX\Sdk\Services\FacebookMessenger\Listeners\DownloadFacebookMessengerAudio;
use PragmaRX\Sdk\Services\FacebookMessenger\Listeners\DownloadFacebookMessengerPhoto;
use PragmaRX\Sdk\Services\FacebookMessenger\Listeners\BroadcastLoggedOutUser;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerDocumentWasCreated;
use PragmaRX\Sdk\Services\FacebookMessenger\Listeners\DownloadFacebookMessengerDocument;
use PragmaRX\Sdk\Services\FacebookMessenger\Listeners\DownloadUserProfilePhotos;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use PragmaRX\Sdk\Services\FacebookMessenger\Listeners\SendFacebookMessengerMessage;

class Event extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
        FacebookMessengerUserWasCreated::class => [
            DownloadUserProfilePhotos::class,
        ],

        FacebookMessengerPhotoWasCreated::class => [
            DownloadFacebookMessengerPhoto::class,
        ],

        FacebookMessengerDocumentWasCreated::class => [
            DownloadFacebookMessengerDocument::class,
        ],

        FacebookMessengerAudioWasCreated::class => [
            DownloadFacebookMessengerAudio::class,
        ],

        FacebookMessengerVoiceWasCreated::class => [
            DownloadFacebookMessengerVoice::class,
        ],

        FacebookMessengerVideoWasCreated::class => [
            DownloadFacebookMessengerVideo::class,
        ],

        ChatMessageWasSent::class => [
            SendFacebookMessengerMessage::class,
        ],
	];
}
