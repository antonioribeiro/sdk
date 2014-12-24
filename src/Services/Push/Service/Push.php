<?php

namespace PragmaRX\Sdk\Services\Push\Service;

use Pusher;

class Push {

	private $pusher;

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

		return $this->pusher->trigger(
			$user.'-CHANNEL-'.$channel,
			$event,
			$data,
			$socket_id,
			$debug,
			$already_encoded
		);
	}

}
