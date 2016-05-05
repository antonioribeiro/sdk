<?php

namespace PragmaRX\Sdk\Core\Database\Eloquent;

use PragmaRX\Sdk\Services\Caching\Service\Facade as Caching;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;

class Builder extends IlluminateEloquentBuilder
{
    public function update(array $values)
    {
        Caching::tags($this->getModel()->getTable())->flush();

        return $this->toBase()->update($this->addUpdatedAtColumn($values));
    }
}
