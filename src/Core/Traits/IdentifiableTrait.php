<?php

namespace PragmaRX\Sdk\Core\Traits;

use Rhumsaa\Uuid\Uuid;

trait IdentifiableTrait {

	public static $hasIdColumn = true;

	/**
	 * Boot model and set id as uuid v4 during creation.
	 *
	 */
	protected static function boot()
	{
		if (static::$hasIdColumn)
		{
			static::creating(function ($model)
			{
				$model->id = (string) Uuid::uuid4();
			});
		}

		parent::boot();
	}

	/**
	 * Save a new model and return the instance.
	 *
	 * @param  array  $attributes
	 * @return static
	 */
	public static function create(array $attributes)
	{
		if (static::$hasIdColumn)
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
	public function save(array $options = array())
	{
		$this->incrementing = false;

		if ( ! $this->exists && static::$hasIdColumn)
		{
			$this->id = (string) Uuid::uuid4();
		}

		return parent::save($options);
	}

}
