<?php

namespace PragmaRX\Sdk\Core\Bus\Events;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Log\Writer;

class EventDispatcher {

	protected $event;

	protected $log;

	function __construct(Dispatcher $event, Writer $log)
	{
		$this->event = $event;

		$this->log = $log;
	}

	public function dispatch(array $events)
	{
		foreach($events as $event)
		{
			$eventName = $this->getEventName($event);
			$this->event->fire($eventName, $event);
			$this->log->info("{$eventName} was fired.");
		}
	}

	protected function getEventName($event)
	{
		return str_replace('\\', '.', get_class($event));
	}

}
