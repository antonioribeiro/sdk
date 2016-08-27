<?php

namespace PragmaRX\Sdk\Core\Traits;

use Ramsey\Uuid\Uuid;

trait IdentifiableTrait 
{
	/**
	 * Boot model and set id as uuid v4 during creation.
	 *
	 */
	protected static function identifiableTraitBoot()
	{
		if (static::canGenerateId())
		{
			static::creating(function ($model)
			{
				$model->id = (string) Uuid::uuid4();
			});
		}
	}

	/**
	 * Save a new model and return the instance.
	 *
	 * @param  array  $attributes
	 * @return static
	 */
	public static function create(array $attributes = [])
	{
		if (static::canGenerateId())
		{
			if (!isset($attributes['id']))
			{
				$attributes['id'] = (string) Uuid::uuid4();
			}
		}

		return parent::create($attributes);
	}

	/**
	 * Save the model to the database.
	 *
	 * @param  array  $options
	 * @return bool
	 */
	public function identifiableSave(array $options = array())
	{
		$this->incrementing = false;

		if ( ! $this->exists && static::$generateId && ! $this->id)
		{
			$this->id = (string) Uuid::uuid4();
		}
	}

    public static function canGenerateId()
    {
        if (property_exists(static::class, 'generateId'))
        {
            return static::$generateId;
        }

        return true;
    }
}
