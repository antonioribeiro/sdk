<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 23/07/2014
 * Time: 20:29
 */

namespace PragmaRX\SDK\Core;

use Laracasts\Presenter\Presenter as LaracastsPresenter;

class Presenter extends LaracastsPresenter {

	public function __get($property)
	{
		if (method_exists($this, $property))
		{
			return $this->{$property}();
		}

		try
		{
			return $this->entity->{$property};
		}
		catch(\LogicException $e)
		{
			// While trying to access an unavailable relationship as
			// an existing model method, Laravel Eloquent (getRelationshipFromMethod)
			// may throw a LogicException, with the message
			//  "Relationship method must return an object of type
			//   Illuminate\Database\Eloquent\Relations\Relation",
			// ignore it and try to call the actual method.
		}

		if (method_exists($this->entity, $property))
		{
			return $this->entity->{$property}();
		}

		return null;
	}

} 
