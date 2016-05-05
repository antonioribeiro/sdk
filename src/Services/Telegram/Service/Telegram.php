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

    public function getWebhookUrl()
    {
        return route(
            'telegram.webhook.handle',
            [
                'robot' => config('env.TELEGRAM_BOT_NAME'),
                'token' => config('env.TELEGRAM_API_TOKEN'),
            ]
        );
    }

    private function initializeBot()
    {
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
//        $this->telegram = new TelegramBot(config('env.TELEGRAM_API_TOKEN'), config('env.TELEGRAM_BOT_NAME'));
    }

    public function setWebhook()
    {
        $result = $this->telegram->setWebHook($this->getWebhookUrl());

        return $this->description = $result->getDescription();
    }

    public function handle()
    {
        $this->telegram->handle();
    }
}
