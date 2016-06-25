<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Service;

use PragmaRX\Sdk\Services\Files\Data\Repositories\File as FileRepository;

class FacebookMessenger
{
    private $botName;

    private $botToken;

    private $description;

    private $facebookMessenger;

    private $initialized = false;

    public function __construct($botName = null, $botToken = null)
    {
        $this->fileRepository = app(FileRepository::class);

        $this->configureBot($botName, $botToken);
    }

    /**
     * @param $botName
     * @param $botToken
     */
    public function configureBot($botName, $botToken)
    {
        $this->setBotName($botName);

        $this->setBotToken($botToken);
    }

    public function getWebhookUrl()
    {
        return route(
            'facebookMessenger.webhook.handle',
            [
                'robot' => $this->botName,
                'token' => $this->botToken,
            ]
        );
    }

    private function initializeBot()
    {
        if ($this->initialized)
        {
            return false;
        }

        if (! $this->botToken || ! $this->botName)
        {
            return false;
        }

        $this->facebookMessenger = new FacebookMessengerBot($this->botToken, $this->botName);

        FacebookMessengerRequest::initialize($this->facebookMessenger);
    }

    /**
     * @param mixed $botName
     */
    public function setBotName($botName)
    {
        if ($this->botName !== $botName)
        {
            $this->initialized = false;
        }

        $this->botName = $botName;

        $this->initializeBot();
    }

    /**
     * @param mixed $botToken
     */
    public function setBotToken($botToken)
    {
        if ($this->botToken !== $botToken)
        {
            $this->initialized = false;
        }

        $this->botToken = $botToken;

        $this->initializeBot();
    }

    public function setWebhook()
    {
        $result = $this->facebookMessenger->setWebHook($this->getWebhookUrl($this->botName, $this->botToken));

        return $this->description = $result->getDescription();
    }

    public function handle()
    {
        $this->facebookMessenger->handle();
    }

    public function getUserProfilePhotos($data)
    {
        return FacebookMessengerRequest::getUserProfilePhotos($data);
    }

    public function makeFileUrl($file, $path)
    {
        return 'https://api.telegram.org/file/bot' . $this->botToken . '/' . $path;
    }

    public function downloadFile($url, $height = null, $width = null)
    {
        return $this->fileRepository->downloadFile($url, $height, $width);
    }

    public function getFile($fileId)
    {
        $response = FacebookMessengerRequest::getFile($fileId);

        return $response->getResult();
    }

    public function sendMessage($chatId, $text, $botName, $botToken)
    {
        $this->configureBot($botName, $botToken);

        return FacebookMessengerRequest::sendMessage(
            [
                'text' => $text,
                'chat_id' => $chatId,
            ]
        );
    }
}
