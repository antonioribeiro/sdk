<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class BusinessClient extends Presenter
{
	public function chatLink()
	{
		return route('chat.client.create', ['clientId' => $this->entity->id]);
	}
}
