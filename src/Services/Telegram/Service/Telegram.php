<?php

namespace PragmaRX\Sdk\Services\Telegram\Service;

use Longman\TelegramBot\Telegram as TelegramBot;
use Longman\TelegramBot\Request as TelegramRequest;
use PragmaRX\Sdk\Services\Files\Data\Repositories\File as FileRepository;

class Telegram
{
    private $botName;

    private $botToken;

    private $description;

    /**
     * @var \Longman\TelegramBot\Telegram
     */
    private $telegram;

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
            'telegram.webhook.handle',
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

        $this->telegram = new TelegramBot($this->botToken, $this->botName);

        TelegramRequest::initialize($this->telegram);
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
        $result = $this->telegram->setWebHook($this->getWebhookUrl($this->botName, $this->botToken));

        return $this->description = $result->getDescription();
    }

    public function handle()
    {
        $this->telegram->handle();
    }

    public function getUserProfilePhotos($data)
    {
        return TelegramRequest::getUserProfilePhotos($data);
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
        $response = TelegramRequest::getFile($fileId);

        return $response->getResult();
    }

    public function sendMessage($text, $botName, $botToken)
    {
        $this->configureBot($botName, $botToken);

        return TelegramRequest::sendMessage(['text' => $text]);
    }
}
