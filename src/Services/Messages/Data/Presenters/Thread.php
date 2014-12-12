<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;
use PragmaRX\Sdk\Services\Messages\Data\Entities\Participant;
use Auth;

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
		$participant = Participant::
						where('thread_id', $this->entity->id)->
						where('user_id', Auth::user()->id)->
						first();

		return $participant
				->folder
				->name;
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
