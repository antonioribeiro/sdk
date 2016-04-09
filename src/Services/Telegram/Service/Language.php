<?php

namespace PragmaRX\Sdk\Services\Telegram\Service;

use Longman\TelegramBot\Telegram as TelegramBot;

class Telegram
{
    private $description;

    private $telegram;

    function __construct()
	{
        $this->telegram = $this->initializeBot();
	}

    private function initializeBot()
    {
        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_KEY'), config('env.TELEGRAM_BOT_NAME'));
    }

    public function setWebhook()
    {
        $result = $this->telegram->setWebHook(config('env.TELEGRAM_WEB_HOOK_URL'));

        $this->description = $result->getDescription();
    }

    public function handle()
    {
        $this->telegram->handle();
    }
}
