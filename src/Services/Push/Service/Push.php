<?php

namespace PragmaRX\Sdk\Services\Push\Service;

use Pusher;

class Push {

	protected $pushed = [];

	protected $pusher;

	public function __construct($public, $secret, $app)
	{
		$this->pusher = new Pusher($public, $secret, $app);
	}

	public function fire($channel, $event, $data, $user = '', $socket_id = null, $debug = false, $already_encoded = false)
	{
		if (is_object($user))
	    {
	        $user = "-USER-{$user->id}";
	    }

		$channel = $user.'-CHANNEL-'.$channel;

		if ( ! $this->wasPushed($user, $channel))
		{
			return $this->pusher->trigger(
				$channel,
				$event,
				$data,
				$socket_id,
				$debug,
				$already_encoded
			);
		}

		return false;
	}

	private function wasPushed($user, $channel)
	{
		if ( ! $wasPushed = isset($this->pushed[$user . $channel]))
		{
			$this->pushed[$user . $channel] = $user . $channel;
		}

		return $wasPushed;
	}

}
