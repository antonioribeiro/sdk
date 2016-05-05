<?php

namespace PragmaRX\Sdk\Core\Traits;

use PragmaRX\Sdk\Services\Caching\Service\Facade as Caching;

trait CachableTrait
{
    public static function firstOrCreateCached(array $attributes)
    {
        list($model, $key) = static::getCached($attributes);

        if (! $model)
        {
            $model = parent::firstOrCreate($attributes);

            static::putCached($key, $model);
        }

        return $model;
    }

    public static function putCached($key, $model)
    {
        Caching::put($key, $model, config('env.CACHE_DATABASE_TIME'));
    }

    public static function createOrUpdateCached(array $attributes = [], $searchKey)
    {
        if (! is_array($searchKey))
        {
            $searchKey = [$searchKey];
        }

        if (is_null($attributes[$searchKey[0]]))
        {
            return null;
        }

        list($model, $key) = static::getCached($attributes, $searchKey);

        if (! $model)
        {
            $model = parent::createOrUpdate($attributes, $searchKey);

            static::putCached($key, $model);
        }

        return $model;
    }

    public static function makeKey($attributes, $searchKey = null, $key = null)
    {
        if ($searchKey)
        {
            $attributes = array_only($attributes, $searchKey);
        }

        if (! $key)
        {
            $key = str_slug(static::class);
        }

        foreach ($attributes as $index => $attribute)
        {
            $key .= sprintf('-{%s => %s}', (string) $index, (string) $attribute);
        }

        return sha1($key);
    }

    public static function getCached($attributes, $searchKey = null, $key = null)
    {
        $key = static::makeKey($attributes, $searchKey, $key);

        if (Caching::has($key))
        {
            return [Caching::get($key), $key];
        }

        return [null, $key];
    }
}
