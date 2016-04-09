<?php

namespace PragmaRX\Sdk\Services\Telegram\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

class Telegram extends BaseController
{
	public function handleWebhook()
	{
        \Log::info(\Input::all());
        
        return $this->success();
	}
}
