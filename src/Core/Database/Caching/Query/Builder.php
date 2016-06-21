<?php

namespace PragmaRX\Sdk\Core\Database\Caching\Query;

//use Watson\Rememberable\Query\Builder as WatsonQueryBuilder;

class Builder extends LaravelQueryBuilder
{
    public function cacheTags()
    {
        return $this;
    }

    public function remember()
    {
        return $this;
    }
}
