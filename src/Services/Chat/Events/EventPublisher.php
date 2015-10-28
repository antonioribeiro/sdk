<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use Redis;

class EventPublisher
{
	const CHANNEL = 'chat-channel';

	public function publish($event, $data = null, $username = null)
	{
		$message = $this->makeMessage($event, $data, $username);

		Redis::publish(static::CHANNEL, json_encode($message));
	}

	/**
	 * @param $event
	 * @param $data
	 * @return array
	 */
	private function makeMessage($event, $data = null, $username = null)
	{
		$message = [
			'event' => $event,
		    'data' => $data,
		    'username' => $username,
		];

		return $message;
	}
}
