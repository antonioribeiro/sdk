<?php

namespace PragmaRX\Sdk\Services\Bus\Events;

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
	public function dispatchEventsFor($entities)
	{
		$entities = is_array($entities) ? $entities : [$entities];

		$results = [];

		foreach ($entities as $entity)
		{
			$results[] = $this->dispatchEventsForEntity($entity);
		}

		return count($results) > 1 ? $results : $results[0];
	}

	public function dispatchEventsForEntity($entity)
	{
		if ( ! is_array($events = $entity->releaseEvents()))
		{
			return $this->getDispatcher()->dispatch($events);
		}

		$result = [];

		foreach ($events as $event)
		{
			$result[] = app('events')->fire($event, $entity);
		}

		if (count($result) == 1)
		{
			$result = $result[0];
		}

		return $result;
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
		return $this->dispatcher ?: App::make('PragmaRX\Sdk\Services\Bus\Service\Dispatcher');
	}
}
