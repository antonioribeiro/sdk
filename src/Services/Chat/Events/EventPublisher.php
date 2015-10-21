<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use Redis;

class EventPublisher
{
	const CHANNEL = 'chat-channel';

	public function publish($event, $username = null, $data = null)
	{
		$message = $this->makeMessage($event, $username, $data);

		Redis::publish(static::CHANNEL, json_encode($message));
	}

	/**
	 * @param $event
	 * @param $data
	 * @return array
	 */
	private function makeMessage($event, $username, $data)
	{
		$message = ['event' => $event];

		$data = [
			'data' => $data,
		    'username' => $username ?: 'unavailable',
		];

		return $message;
	}
}
