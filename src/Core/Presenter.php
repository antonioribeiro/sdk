<?php

namespace PragmaRX\Sdk\Core;

use PragmaRX\Sdk\Services\Presenter\Presenter as SdkPresenter;

class Presenter extends SdkPresenter {

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

    public function humanDateFormat()
    {
        return 'd/m/Y H:i:s';
    }

    public function createdAt()
    {
        if ($this->entity->created_at)
        {
            return $this->entity->created_at->format($this->humanDateFormat());
        }
    }

    public function updatedAt()
    {
        if ($this->entity->updated_at)
        {
            return $this->entity->updated_at->format($this->humanDateFormat());
        }
    }
}
