<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramBot;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramFile;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramUser;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramChat;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramVenue;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramVideo;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramVoice;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramAudio;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramPhoto;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramMessage;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramSticker;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramContact;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramDocument;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramChatType;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramLocation;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramDocumentWasCreated;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramMessageReceived;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramPhotoWasCreated;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramUserWasCreated;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramVideoWasCreated;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramVoiceWasCreated;
use PragmaRX\Sdk\Services\Telegram\Service\Facade as TelegramService;
use PragmaRX\Sdk\Services\Files\Data\Repositories\File as FileRepository;

class Telegram
{
    /**
     * @var FileRepository
     */
    private $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    private function clearMessage($message)
    {
        return strip_tags($message);
    }

    /**
     * @param $bot
     */
    private function configureServiceBot($bot)
    {
        if ($bot)
        {
            TelegramService::configureBot($bot->name, $bot->token);
        }
    }

    /**
     * @param $photo
     * @param $bot
     * @return null|static
     */
    private function createOrUpdatePhoto($photo, $bot)
    {
        $photo = TelegramPhoto::createOrUpdate(
            $photo,
            'telegram_file_id'
        );

        if ($photo && $photo->wasRecentlyCreated)
        {
            event(new TelegramPhotoWasCreated($photo, $bot));
        }

        return $photo;
    }

    /**
     * @param $document
     * @param $bot
     * @return mixed
     */
    private function downloadTelegramFile($document, $bot, $hasThumb = false)
    {
        $this->configureServiceBot($bot);

        if ($document && !$document->file_name_id && $downloadable = $this->extractDocument($document)) {
            $fileName = $this->downloadAndMakeFileName($downloadable);

            $document->file_name_id = $fileName->id;

            $document->save();
        }

        if ($hasThumb)
        {
            $this->downloadPhoto($document->thumb, $bot);
        }

        return $document;
    }

    public function downloadVoice($voice, $bot)
    {
        return $this->downloadTelegramFile($voice, $bot, false);
    }

    public function downloadDocument($document, $bot)
    {
        return $this->downloadTelegramFile($document, $bot, true);
    }

    public function downloadVideo($document, $bot)
    {
        return $this->downloadTelegramFile($document, $bot, true);
    }

    public function downloadUserAvatar($user, $bot = null)
    {
        $this->configureServiceBot($bot);

        if (! $user)
        {
            return null;
        }

        if ($user->hasAvatar)
        {
            return $user->photos;
        }

        $data = [
            'user_id' => $user->telegram_id
        ];

        $photos = $this->extractPhotos(TelegramService::getUserProfilePhotos($data)->getResult()->getPhotos());

        $avatar = null;

        $downloaded = false;

        // Telegram may have too many photo profiles
        // Download only the first photo
        $key = 0;

        if ($fileName = $this->downloadAndMakeFileName($photos[$key]))
        {
            $photos[$key]['telegram_file_id'] = $photos[$key]['file_id'];

            $photos[$key]['file_name_id'] = $fileName->id;

            $downloaded = true;
        }

        if ($downloaded)
        {
            $user->photos = json_encode($photos);

            if (isset($photos[0]['file_name_id']))
            {
                $user->avatar_id = $photos[0]['file_name_id'];
            }

            $user->save();
        }

        return $user->photos;
    }

    public function downloadPhoto($photo, $bot = null)
    {
        return $this->downloadTelegramFile($photo, $bot, false);
    }

    private function extractDocument($document)
    {
        return [
            'file_id' => $document->telegram_file_id,
            'file_size' => $document->file_size,
        ];
    }

    private function extractPhotos($photos)
    {
        if (is_array($photos))
        {
            $photos = Arr::flatten($photos);

            foreach ($photos as $key => $photo)
            {
                $photos[$key] = [
                    'file_id' => $photo->getFileId(),
                    'width' => $photo->getWidth(),
                    'height' => $photo->getHeight(),
                    'file_size' => $photo->getFileSize(),
                ];
            }
        }

        if ($photos instanceof TelegramPhoto)
        {
            $photos = [[
                'file_id' => $photos->telegram_file_id,
                'width' => $photos->width,
                'height' => $photos->height,
                'file_size' => $photos->file_size,
            ]];
        }

        return $photos;
    }

    public function findMessageById($telegram_message_id)
    {
        return TelegramMessage::find($telegram_message_id);
    }

    private function firstOrCreateAudio($audio, $bot)
    {
        $audio = TelegramAudio::createOrUpdate(
            [
                'telegram_file_id' => array_get($audio, 'file_id'),
                'duration' => array_get($audio, 'duration'),
                'performer' => array_get($audio, 'performer'),
                'title' => array_get($audio, 'title'),
                'mime_type' => array_get($audio, 'mime_type'),
                'file_size' => array_get($audio, 'file_size'),
            ],
            'telegram_file_id'
        );

        if ($audio && $audio->wasRecentlyCreated)
        {
            event(new TelegramAudioWasCreated($audio, $bot));
        }

        return $audio;
    }

    private function firstOrCreateChat($chat, $bot)
    {
        return TelegramChat::createOrUpdate(
            [
                'telegram_id' => $chat['id'],
                'bot_id' => $bot->id,
                'telegram_chat_type_id' => $this->firstOrCreateType($chat['type'])->id,
                'title' => array_get($chat, 'title'),
                'username' => array_get($chat, 'username'),
                'first_name' => array_get($chat, 'first_name'),
                'last_name' => array_get($chat, 'last_name'),
            ],
            'telegram_id'
        );
    }

    private function firstOrCreateContact($contact)
    {
        return TelegramContact::createOrUpdate(
            [
                'phone_number' => array_get($contact, 'phone_number'),
                'first_name' => array_get($contact, 'first_name'),
                'last_name' => array_get($contact, 'last_name'),
                'telegram_user_id' => array_get($contact, 'user_id'),
            ],
            'phone_number'
        );
    }

    private function firstOrCreateDocument($document, $bot)
    {
        $thumb = $this->firstOrCreatePhoto(array_get($document, 'thumb'), $bot);

        $document = TelegramDocument::createOrUpdate(
            [
                'telegram_file_id' => array_get($document, 'file_id'),
                'thumb_id' => $thumb ? $thumb->id : null,
                'file_name' => array_get($document, 'file_name'),
                'mime_type' => array_get($document, 'mime_type'),
                'file_size' => array_get($document, 'file_size'),
            ],
            'telegram_file_id'
        );

        if ($document && $document->wasRecentlyCreated)
        {
            event(new TelegramDocumentWasCreated($document, $bot));
        }

        return $document;
    }

    private function firstOrCreateLocation($location)
    {
        if (! $location)
        {
            return null;
        }

        return TelegramLocation::firstOrCreate($location);
    }

    private function firstOrCreateMessage($data, $bot)
    {
        TelegramService::configureBot($bot->name, $bot->token);

        $user = $this->firstOrCreateUser(array_get($data, 'from'), $bot);

        $chat = $this->firstOrCreateChat(array_get($data, 'chat'), $bot);

        $forward_from = $this->firstOrCreateUser(array_get($data, 'forward_from_id'), $bot);

        $audio = $this->firstOrCreateAudio(array_get($data, 'audio'), $bot);

        $document = $this->firstOrCreateDocument(array_get($data, 'document'), $bot);

        $photo = $this->firstOrCreatePhoto(array_get($data, 'photo'), $bot);

        $sticker = $this->firstOrCreateSticker(array_get($data, 'sticker'), $bot);

        $video = $this->firstOrCreateVideo(array_get($data, 'video'), $bot);

        $voice = $this->firstOrCreateVoice(array_get($data, 'voice'), $bot);

        $contact = $this->firstOrCreateContact(array_get($data, 'contact'), $bot);

        $location = $this->firstOrCreateLocation(array_get($data, 'location'), $bot);

        $new_chat_participant = $this->firstOrCreateUser(array_get($data, 'new_chat_participant'), $bot);

        $left_chat_participant_id = $this->firstOrCreateUser(array_get($data, 'left_chat_participant_id'), $bot);

        $new_chat_photo = $this->firstOrCreatePhoto(array_get($data, 'new_chat_photo'), $bot);

        $venue = $this->firstOrCreateVenue(array_get($data, 'venue'), $bot);

        return TelegramMessage::createOrUpdate(
            [
                'telegram_message_id' => $data['message_id'],
                'from_id' => $user ? $user->id : null,
                'date' => $data['date'],
                'timestamp' => Carbon::createFromTimestamp($data['date']),
                'chat_id' => $chat ? $chat->id : null,
                'text' => array_get($data, 'text'),
                'forward_from_id' => $forward_from ? $forward_from->id : null,
                'forward_date' => array_get($data, 'forward_date'),
                // 'reply_to_message_id', /// it's a message, will have to think better about this
                'audio_id' => $audio ? $audio->id : null,
                'document_id' => $document ? $document->id : null,
                'photo' => is_array($photo) ? json_encode($photo) : json_encode([]),
                'entities' => json_encode(array_get($data, 'entities')),
                'sticker_id' => $sticker ? $sticker->id : null,
                'video_id' => $video ? $video->id : null,
                'voice_id' => $voice ? $voice->id : null,
                'venue_id' => $venue ? $venue->id : null,
                'caption' => array_get($data, 'caption'),
                'contact_id' => $contact ? $contact->id : null,
                'location_id' => $location ? $location->id : null,
                'new_chat_participant_id' => $new_chat_participant ? $new_chat_participant->id : null,
                'left_chat_participant_id' => $left_chat_participant_id ? $left_chat_participant_id->id : null,
                'new_chat_title' => array_get($data, 'new_chat_title'),
                'new_chat_photo' => $new_chat_photo ? $new_chat_photo->id : null,
                'delete_chat_photo' => array_get($data, 'delete_chat_photo'),
                'group_chat_created' => array_get($data, 'group_chat_created'),
                'supergroup_chat_created' => array_get($data, 'supergroup_chat_created'),
                'channel_chat_created' => array_get($data, 'channel_chat_created'),
                'migrate_to_chat_id' => array_get($data, 'migrate_to_chat_id'),
                'migrate_from_chat_id' => array_get($data, 'migrate_from_chat_id'),
            ],
            ['telegram_message_id', 'chat_id']
        );
    }

    private function firstOrCreateBot($bot, $token)
    {
        return TelegramBot::firstOrCreate([
            'name' => $bot,
            'token' => $token,
        ]);
    }

    private function firstOrCreatePhoto($photos, $bot)
    {
        if (is_array($photos) && ! isset($photos['width']))
        {
            $result = [];

            foreach ($photos as $photo)
            {
                $photoArray = $this->makePhotoArray($photo);

                $result[] = $this->makePhotoArray(
                    $photoArray,
                    'id',
                    $this->firstOrCreatePhoto($photoArray, $bot)->id
                );
            }

            return $result;
        }

        $photo = $this->makePhotoArray($photos);

        return $this->createOrUpdatePhoto($photo, $bot);
    }

    private function firstOrCreateSticker($sticker, $bot)
    {
        $thumb = $this->firstOrCreatePhoto(array_get($sticker, 'thumb'), $bot);

        return TelegramSticker::createOrUpdate(
            [
                'telegram_file_id' => array_get($sticker, 'file_id'),
                'width' => array_get($sticker, 'width'),
                'height' => array_get($sticker, 'height'),
                'thumb_id' => $thumb ? $thumb->id : null,
                'file_size' => array_get($sticker, 'file_size'),
            ],
            'telegram_file_id'
        );
    }

    private function firstOrCreateType($type)
    {
        return TelegramChatType::firstOrCreate(['name' => $type]);
    }

    private function firstOrCreateUser($user, $bot)
    {
        $user = TelegramUser::createOrUpdate(
            [
                'telegram_id' => array_get($user, 'id'),
                'first_name' => array_get($user, 'first_name'),
                'last_name' => array_get($user, 'last_name'),
                'username' => array_get($user, 'username'),
            ],
            'telegram_id'
        );

        event(new TelegramUserWasCreated($user, $bot));

        return $user;
    }

    private function firstOrCreateVenue($data)
    {
        if (! $location = $this->firstOrCreateLocation($data['location']))
        {
            return null;
        }

        return TelegramVenue::firstOrCreate(
            [
                'location_id' => isset($location) ? $location->id : null,
                'title' => array_get($data, 'title'),
                'address' => array_get($data, 'address'),
                'foursquare_id' => array_get($data, 'foursquare_id'),
            ]
        );
    }

    private function firstOrCreateVideo($video, $bot)
    {
        $thumb = $this->firstOrCreatePhoto(array_get($video, 'thumb'), $bot);

        $video = TelegramVideo::createOrUpdate(
            [
                'telegram_file_id' => array_get($video, 'file_id'),
                'width' => array_get($video, 'width'),
                'height' => array_get($video, 'height'),
                'duration' => array_get($video, 'duration'),
                'thumb_id' => $thumb ? $thumb->id : null,
                'mime_type' => array_get($video, 'mime_type'),
                'file_size' => array_get($video, 'file_size'),
            ],
            'telegram_file_id'
        );

        if ($video && $video->wasRecentlyCreated)
        {
            event(new TelegramVideoWasCreated($video, $bot));
        }

        return $video;
    }

    private function firstOrCreateVoice($voice, $bot)
    {
        $voice = TelegramVoice::createOrUpdate(
            [
                'telegram_file_id' => array_get($voice, 'file_id'),
                'duration' => array_get($voice, 'duration'),
                'mime_type' => array_get($voice, 'mime_type'),
                'file_size' => array_get($voice, 'file_size'),
            ],
            'telegram_file_id'
        );

        if ($voice && $voice->wasRecentlyCreated)
        {
            event(new TelegramVoiceWasCreated($voice, $bot));
        }

        return $voice;
    }

    /**
     * @param $file
     * @return mixed
     */
    private function downloadAndMakeFileName($file)
    {
        $telegramFile = TelegramFile::where('telegram_file_id', $file['file_id'])->first();

        if ($telegramFile)
        {
            return $telegramFile->fileName;
        }
        
        if (! $telegramFile = TelegramService::getFile($file))
        {
            return null;
        }

        $fileName = TelegramService::downloadFile(
            TelegramService::makeFileUrl($file, $telegramFile->getFilePath()),
            isset($file['width']) ? $file['width'] : null,
            isset($file['height']) ? $file['height'] : null
        );

        TelegramFile::create([
             'telegram_file_id' => $file['file_id'],
             'file_name_id' => $fileName->id,
             'file_size' => $file['file_size'],
             'file_path' => '',
        ]);

        return $fileName;
    }

    private function logData($data)
    {
        \Log::info($data);
    }

    private function makePhotoArray($photo, $idColumnName = 'telegram_file_id', $idColumnValue = null)
    {
        $value = array_get($photo, 'file_id') ?: array_get($photo, $idColumnName);

        $result = [
            $idColumnName => $idColumnValue ?: $value,
            'width' => array_get($photo, 'width'),
            'height' => array_get($photo, 'height'),
            'file_size' => array_get($photo, 'file_size'),
        ];

        return $result;
    }

    public function receive($bot, $token, $data)
    {
        $this->logData($data);

        $message = $this->firstOrCreateMessage(
            $data['message'],
            $this->firstOrCreateBot($bot, $token)
        );

        event(new TelegramMessageReceived($message));
	}

    public function sendMessage($message)
    {
        return TelegramService::sendMessage(
            $message->chat->telegramChat->telegram_id,
            $this->clearMessage($message->message),
            $message->chat->telegramChat->bot->name,
            $message->chat->telegramChat->bot->token
        );
    }

    public function isCommand($string)
    {
        return $string == '/start';
    }
}
