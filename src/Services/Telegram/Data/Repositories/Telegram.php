<?php

namespace PragmaRX\Sdk\Services\Products\Data\Repositories;

use PragmaRX\Sdk\Services\Products\Data\Entities\Products as Model;

class Telegram
{
    public function receive($data)
    {
        if (isset($all['message']))
        {
            return $this->receiveMessage($data['message']);
        }
	}

    private function receiveMessage($all)
    {

    }
}
