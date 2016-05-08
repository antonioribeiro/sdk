<?php

namespace PragmaRX\Sdk\Core\Traits;

trait CachableTrait
{
    public function firstOrCreateCached(array $attributes)
    {
        list($model, $key) = $this->getCached($attributes);

        if (! $model)
        {
            $model = parent::firstOrCreate($attributes);

            $this->putCached($key, $model);
        }

        return $model;
    }

    public function cache($tags, $key, $model)
    {
        $this->tags($tags)->put($key, $model, config('env.CACHE_DATABASE_TIME'));
    }

    public function createOrUpdateCached(array $attributes = [], $searchKey)
    {
        if (! is_array($searchKey))
        {
            $searchKey = [$searchKey];
        }

        if (is_null($attributes[$searchKey[0]]))
        {
            return null;
        }

        list($model, $key) = $this->getCached($attributes, $searchKey);

        if (! $model)
        {
            $model = parent::createOrUpdate($attributes, $searchKey);

            $this->putCached($key, $model);
        }

        return $model;
    }

    public function makeKey($attributes, $searchKey = null, $key = null)
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

    public function cached($tags, $attributes, $searchKey = null, $key = null)
    {
        $key = $this->makeKey($attributes, $searchKey, $key);

        if ($result = $this->tags($tags)->get($key))
        {
            return [$result, $key];
        }

        return [null, $key];
    }
}
