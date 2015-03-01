<?php

namespace PragmaRX\Sdk\Core\Bus\Events;

use App;
use Illuminate\Contracts\Events\Dispatcher;

trait DispatchableTrait {
	/**
	 * The Dispatcher instance.
	 *
	 * @var Dispatcher
	 */
	protected $dispatcher;
	/**
	 * Dispatch all events for an entity.
	 *
	 * @param object $entity
	 */
	public function dispatchEventsFor($entity)
	{
		return $this->getDispatcher()->dispatch($entity->releaseEvents());
	}
	/**
	 * Set the dispatcher instance.
	 *
	 * @param mixed $dispatcher
	 */
	public function setDispatcher(Dispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}
	/**
	 * Get the event dispatcher.
	 *
	 * @return Dispatcher
	 */
	public function getDispatcher()
	{
		return $this->dispatcher ?: App::make('PragmaRX\Sdk\Core\Bus\Events\EventDispatcher');
	}
}
