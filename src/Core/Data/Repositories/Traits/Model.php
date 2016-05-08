<?php

namespace PragmaRX\Sdk\Core\Data\Repositories\Traits;

trait Model
{
    public function getModel()
    {
        return $this->model;
    }

    public function getNewModel()
    {
        $model = $this->getModel();
        return app($model);
    }
}
