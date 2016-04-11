<?php

namespace PragmaRX\Sdk\Services\Telegram\Service;

use Longman\TelegramBot\Telegram as TelegramBot;

class Telegram
{
    private $botName;

    private $botToken;

    private $description;

    private $telegram;

    public function __construct($botName = null, $botToken = null)
	{
        $this->setBotName($botName ?: config('env.TELEGRAM_BOT_NAME'));

        $this->setBotToken($botToken ?: config('env.TELEGRAM_API_TOKEN'));

        $this->initializeBot();
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
        $this->telegram = new TelegramBot($this->botToken, $this->botName);
    }

    /**
     * @param mixed $botName
     */
    public function setBotName($botName)
    {
        $this->botName = $botName;
    }

    /**
     * @param mixed $botToken
     */
    public function setBotToken($botToken)
    {
        $this->botToken = $botToken;
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
