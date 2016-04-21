<?php

namespace PragmaRX\Sdk\Services\Telegram\Service;

use Longman\TelegramBot\Telegram as TelegramBot;
use Longman\TelegramBot\Request as TelegramRequest;

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
}
