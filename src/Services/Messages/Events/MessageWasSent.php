<?php

namespace PragmaRX\Sdk\Services\Messages\Events;


class MessageWasSent {

	public $thread;

	function __construct($thread)
	{
		$this->thread = $thread;
	}

}
