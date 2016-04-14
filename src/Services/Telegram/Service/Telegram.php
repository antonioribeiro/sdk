<?php

namespace PragmaRX\Sdk\Services\Telegram\Service;

use Longman\TelegramBot\Telegram as TelegramBot;

class Telegram
{
    private $botName;

    private $botToken;

    private $description;

    private $telegram;

    private $initialized = false;

    public function __construct($botName = null, $botToken = null)
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
}
