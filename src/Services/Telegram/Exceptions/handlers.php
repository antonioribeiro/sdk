<?php

use Longman\TelegramBot\Exception\TelegramException;

if (class_exists(Longman\TelegramBot\Exception\TelegramException::class))
{
    ExceptionHandler::addHandler(function(TelegramException $exception, $code)
    {
        \Flash::error($exception->getMessage());

        return redirect()->back()->withInput();
    });
}
