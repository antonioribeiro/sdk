<?php

namespace PragmaRX\Sdk\Services\Products\Data\Repositories;

use Carbon\Carbon;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramBot;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramUser;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramChat;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramVideo;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramVoice;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramAudio;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramPhoto;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramMessage;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramSticker;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramContact;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramDocument;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramChatType;

class Telegram
{
    private function firstOrCreateAudio($audio)
    {
        return TelegramAudio::createOrUpdate(
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

    private function firstOrCreateDocument($document)
    {
        $thumb = $this->firstOrCreatePhoto(array_get($document, 'thumb'));

        return TelegramDocument::createOrUpdate(
            [
                'telegram_file_id' => array_get($document, 'file_id'),
                'thumb_id' => $thumb ? $thumb->id : null,
                'file_name' => array_get($document, 'file_name'),
                'mime_type' => array_get($document, 'mime_type'),
                'file_size' => array_get($document, 'file_size'),
            ],
            'telegram_file_id'
        );
    }

    private function firstOrCreateLocation($location)
    {
        if (! $location)
        {
            return null;
        }

        return TelegramDocument::firstOrCreate($location);
    }

    private function firstOrCreateMessage($data, $bot)
    {
        $user = $this->firstOrCreateUser(array_get($data, 'from'));

        $chat = $this->firstOrCreateChat(array_get($data, 'chat'), $bot);

        $forward_from = $this->firstOrCreateUser(array_get($data, 'forward_from_id'));

        $audio = $this->firstOrCreateAudio(array_get($data, 'audio'));

        $document = $this->firstOrCreateDocument(array_get($data, 'document'));

        $photo = $this->firstOrCreatePhoto(array_get($data, 'photo'));

        $sticker = $this->firstOrCreateSticker(array_get($data, 'sticker'));

        $video = $this->firstOrCreateVideo(array_get($data, 'video'));

        $voice = $this->firstOrCreateVoice(array_get($data, 'voice'));

        $contact = $this->firstOrCreateContact(array_get($data, 'contact'));

        $location = $this->firstOrCreateLocation(array_get($data, 'location'));

        $new_chat_participant = $this->firstOrCreateUser(array_get($data, 'new_chat_participant'));

        $left_chat_participant_id = $this->firstOrCreateUser(array_get($data, 'left_chat_participant_id'));

        $new_chat_photo = $this->firstOrCreatePhoto(array_get($data, 'new_chat_photo'));

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
                'sticker_id' => $sticker ? $sticker->id : null,
                'video_id' => $video ? $video->id : null,
                'voice_id' => $voice ? $voice->id : null,
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

    private function firstOrCreatePhoto($photos)
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
                    $this->firstOrCreatePhoto($photoArray)->id
                );
            }

            return $result;
        }

        $photo = $this->makePhotoArray($photos);

        return TelegramPhoto::createOrUpdate(
            $photo,
            'telegram_file_id'
        );
    }

    private function firstOrCreateSticker($sticker)
    {
        $thumb = $this->firstOrCreatePhoto(array_get($sticker, 'thumb'));

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

    private function firstOrCreateUser($user)
    {
        return TelegramUser::createOrUpdate(
            [
                'telegram_id' => array_get($user, 'id'),
                'first_name' => array_get($user, 'first_name'),
                'last_name' => array_get($user, 'last_name'),
                'username' => array_get($user, 'username'),
            ],
            'telegram_id'
        );
    }

    private function firstOrCreateVideo($video)
    {
        $thumb = $this->firstOrCreatePhoto(array_get($video, 'thumb'));

        return TelegramVideo::createOrUpdate(
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
    }

    private function firstOrCreateVoice($voice)
    {
        return TelegramVoice::createOrUpdate(
            [
                'telegram_file_id' => array_get($voice, 'file_id'),
                'duration' => array_get($voice, 'duration'),
                'mime_type' => array_get($voice, 'mime_type'),
                'file_size' => array_get($voice, 'file_size'),
            ],
            'telegram_file_id'
        );
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

        return $this->firstOrCreateMessage(
            $data['message'],
            $this->firstOrCreateBot($bot, $token)
        );
	}
}
