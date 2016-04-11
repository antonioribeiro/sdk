<?php

namespace PragmaRX\Sdk\Services\Telegram\Service;

use Longman\TelegramBot\Telegram as TelegramBot;

class Telegram
{
    private $description;

    private $telegram;

    public function __construct()
	{
        $this->initializeBot();
	}

    public function getWebhookUrl($botName = null, $botToken = null)
    {
        return route(
            'telegram.webhook.handle',
            [
                'robot' => $botName ?: config('env.TELEGRAM_BOT_NAME'),
                'token' => $botToken ?: config('env.TELEGRAM_API_TOKEN'),
            ]
        );
    }

    private function initializeBot()
    {
        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
    }

    public function setWebhook($botName, $botToken)
    {
        $result = $this->telegram->setWebHook($this->getWebhookUrl($botName, $botToken));

        return $this->description = $result->getDescription();
    }

    public function handle()
    {
        $this->telegram->handle();
    }
}
