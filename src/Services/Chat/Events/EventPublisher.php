<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use Redis;

class EventPublisher
{
	const CHANNEL = 'chat-channel';

    const EVENT_OCCURED = 'EventOccured';

	public function publish($event, $data = null, $username = null)
	{
//        Redis::publish(static::CHANNEL, $this->makeMessage(static::EVENT_OCCURED, $data, $username));

		Redis::publish(static::CHANNEL, $this->makeMessage($event, $data, $username));
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

		return json_encode($message);
	}
}
