<?php

namespace PragmaRX\Sdk\Services\Push\Service;

use Pusher;

class Push {

	private $pusher;

	public function __construct($public, $secret, $app)
	{
		$this->pusher = new Pusher($public, $secret, $app);
	}

	public function fire($channels, $event, $data, $socket_id = null, $debug = false, $already_encoded = false)
	{
		return $this->pusher->trigger($channels, $event, $data, $socket_id, $debug, $already_encoded);
	}

}
