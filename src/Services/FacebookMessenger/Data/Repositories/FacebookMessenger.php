<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Repositories;

use Carbon\Carbon;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities\FacebookPage;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerUserWasCreated;
use PragmaRX\Sdk\Services\Files\Data\Repositories\File as FileRepository;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities\FacebookMessengerBot;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities\FacebookMessengerUser;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities\FacebookMessengerChat;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities\FacebookMessengerMessage;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerMessageReceived;
use PragmaRX\Sdk\Services\FacebookMessenger\Service\Facade as FacebookMessengerService;

class FacebookMessenger
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
            FacebookMessengerService::configureBot($bot->name, $bot->token);
        }
    }

    public function downloadUserProfileAndAvatar($user, $bot)
    {
        $profile = $user->id;

        if (! $user->name && ! $user->first_name)
        {
            $profile = FacebookMessengerService::getUserProfile($user, $bot);

            $user->name = isset($profile['name']) ? $profile['name'] : null;
            $user->first_name = isset($profile['first_name']) ? $profile['first_name'] : null;
            $user->last_name = isset($profile['last_name']) ? $profile['last_name'] : null;
            $user->profile_pic = isset($profile['profile_pic']) ? $profile['profile_pic'] : null;
            $user->locale = isset($profile['locale']) ? $profile['locale'] : null;
            $user->timezone = isset($profile['timezone']) ? $profile['timezone'] : null;
            $user->gender = isset($profile['gender']) ? $profile['gender'] : null;

            $user->save();
        }
    }

    public function findMessageById($facebook_messenger_message_id)
    {
        return FacebookMessengerMessage::find($facebook_messenger_message_id);
    }

    private function firstOrCreateBot($bot, $token)
    {
        return FacebookMessengerBot::firstOrCreate([
            'name' => $bot,
            'token' => $token,
        ]);
    }

    private function firstOrCreateChat($chatId, $bot)
    {
        return FacebookMessengerChat::createOrUpdate(
            [
                'facebook_messenger_id' => $chatId,
                'bot_id' => $bot->id,
            ],
            'facebook_messenger_id'
        );
    }
    
    private function firstOrCreateMessage($page, $page2, $time, $message)
    {
        FacebookMessengerService::configurePage($page->name, $page->token);

        $sender = $this->firstOrCreateUser(array_get($message, 'sender.id'), $page);

        $recipient = $this->firstOrCreateUser(array_get($message, 'recipient.id'), $page);

        $chat = $this->firstOrCreateChat(array_get($message, 'sender.id'), $page);

        return FacebookMessengerMessage::createOrUpdate(
            [
                'mid' => $message['message']['mid'],
                'seq' => $message['message']['seq'],
                'sender_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'time' => (int) ($time / 1000),
                'timestamp' => Carbon::createFromTimestamp((int) ($message['timestamp'] / 1000)),
                'chat_id' => $chat ? $chat->id : null,
                'text' => isset($message['message']['text']) ? $message['message']['text'] : null,
                'attachments' => isset($message['message']['attachments']) ? json_encode($message['message']['attachments']) : null,
            ],
            ['mid', 'chat_id']
        );
    }

    private function firstOrCreatePage($id)
    {
        return FacebookPage::firstOrCreate(
            ['facebook_id' => $id]
        );
    }

    private function firstOrCreateUser($userId, $bot)
    {
        $user = FacebookMessengerUser::firstOrCreate(
            ['facebook_messenger_id' => $userId]
        );

        if ($user && $user->wasRecentlyCreated)
        {
            event(new FacebookMessengerUserWasCreated($user, $bot));
        }

        return $user;
    }

    private function logData($data)
    {
        \Log::info($data);
    }

    public function receive($bot, $token, $request)
    {
        $this->logData($request->all());

        $robot = $this->firstOrCreateBot($bot, $token);

        foreach ($request->get('entry') as $entry)
        {
            $page = $this->firstOrCreatePage($entry['id']);
            $time = $entry['time'];

            foreach ($entry['messaging'] as $message)
            {
                if (isset($message['message']))
                {
                    $message = $this->firstOrCreateMessage(
                        $robot,
                        $page,
                        $time,
                        $message
                    );
                }
            }
        }

        event(new FacebookMessengerMessageReceived($message));
	}

    public function sendMessage($message)
    {
        return FacebookMessengerService::sendMessage(
            $message->chat->facebookMessengerChat->facebook_messenger_id,
            $this->clearMessage($message->message),
            $message->chat->facebookMessengerChat->bot->name,
            $message->chat->facebookMessengerChat->bot->token
        );
    }

    public function isCommand($string)
    {
        return $string == '/start';
    }
}
