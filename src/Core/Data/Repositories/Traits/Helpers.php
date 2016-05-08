<?php

namespace PragmaRX\Sdk\Core\Data\Repositories\Traits;

trait Helpers
{
    public function getClassName($className)
    {
        $aliases = Config::get('sdk.aliases');

        if (isset($aliases[$className]))
        {
            return $aliases[$className];
        }

        return $className;
    }

    public function getModelFillableAttributes($model = null)
    {
        $model = $model ?: $this->getNewModel();

        return $model->getFillable();
    }
}
