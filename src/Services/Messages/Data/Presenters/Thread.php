<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class Thread extends Presenter {

	public function bodyFirstLine()
	{
		$message = $this->entity
					->messages()
					->orderBy('created_at', 'desc')
					->first();

		$body = $message ? $message->body : null;

		return $this->reduce($body);
	}

	public function currentFolder()
	{
		return 'Inbox';
	}

	private function reduce($first)
	{
		if (strlen($first = strip_tags($first)) > 60)
		{
			$first = substr($first, 0, 60).'...';
		}

		return $first;
	}

}
