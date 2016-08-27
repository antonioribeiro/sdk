<?php

namespace PragmaRX\Sdk\Core\Database\Eloquent;

use PragmaRX\Sdk\Services\Caching\Service\Facade as Caching;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;

class Builder extends IlluminateEloquentBuilder
{
    public function update(array $values)
    {
        // Caching::tags($this->getModel()->getTable())->flush();

        return $this->toBase()->update($this->addUpdatedAtColumn($values));
    }

    public function find($id, $columns = ['*'])
    {
//        list($model, $key) = Caching::cached($this->getModel(), $this->query->from.'-'.$id);
//
//        if ($model)
//        {
//            return $model;
//        }

        if (! $model = parent::find($id, $columns))
        {
            return null;
        }

//        Caching::cache($this->getModel(), $key, $model);

        return $model;
    }
}
