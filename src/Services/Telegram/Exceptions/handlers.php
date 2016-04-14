<?php

use Longman\TelegramBot\Exception\TelegramException;

ExceptionHandler::addHandler(function(TelegramException $exception, $code)
{
    \Flash::error($exception->getMessage());

	return redirect()->back()->withInput();
});
