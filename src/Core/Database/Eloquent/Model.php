<?php

namespace PragmaRX\Sdk\Core\Database\Eloquent;

use PragmaRX\Sdk\Core\Traits\CachableTrait;
use PragmaRX\Sdk\Core\Traits\ReloadableTrait;
use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;
use PragmaRX\Sdk\Services\Bus\Events\EventGenerator;
use PragmaRX\Sdk\Services\Presenter\PresentableTrait;
use PragmaRX\Sdk\Core\Database\Caching\Traits\Rememberable;
use PragmaRX\Sdk\Services\Caching\Service\Facade as Caching;
use PragmaRX\Sdk\Core\Database\Eloquent\Builder as EloquentBuilder;

class Model extends Eloquent
{
    use
//        CachableTrait,
//        Rememberable,
        EventGenerator,
        PresentableTrait,
        ReloadableTrait,
        IdentifiableTrait;

    /**
     * @var array
     */
    protected $pendingEvents = [];

    /**
     * View presenter instance
     *
     * @var mixed
     */
    protected $presenterInstance;

    /**
     * @var bool
     */
    public static $generateId = true;

	protected $revisionCreationsEnabled = true;

	protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'id' => 'string',
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::identifiableTraitBoot();
        parent::boot();
    }

    /**
     * @param array $values
     * @return array
     */
    private static function filterEmptyValues(array $values)
    {
        $values = array_filter(
            $values,
            function ($var) { return ! is_empty_or_null($var); }
        );

        return $values;
    }

    private function getUserId()
	{
		try {
			if (\Auth::check())
			{
				return \Auth::user()->getAuthIdentifier();
			}
		} catch (\Exception $e) {
			return null;
		}

		return null;
	}

    public static function createOrUpdate(array $values = [], $searchKey)
    {
        $values = self::filterEmptyValues($values);

        if (! $values)
        {
            return null;
        }

        $instance = new static();

        $keys = array_only($values, $searchKey);

        if (is_null($model = $instance->where($keys)->first()))
        {
            $instance = $instance->create($values);

            return $instance;
        }

        $model->fill($values);

        $model->save();

        return $model;
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new EloquentBuilder($query);
    }

    public function save(array $options = array())
    {
        // Caching::tags($this->getModel()->getTable())->flush();

        $this->identifiableSave();

        return parent::save($options);
    }
}
