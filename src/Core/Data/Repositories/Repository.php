<?php

namespace PragmaRX\Sdk\Core\Data\Repositories;

use Config;
use PragmaRX\Sdk\Core\Data\Repositories\Traits\Find;

class Repository
{
    use Find;

	protected $model = '';

	public function getModel()
	{
		return $this->model;
	}

	public function getNewModel()
	{
		$model = $this->getModel();

		return app($model);
	}

	public function getClassName($className)
	{
		$aliases = Config::get('sdk.aliases');

		if (isset($aliases[$className]))
		{
			return $aliases[$className];
		}

		return $className;
	}

	protected function call($className, $method = null, $arguments = [])
	{
		return call($this->getClassName($className), $method, $arguments);
	}

	public function getModelFillableAttributes($model = null)
	{
		$model = $model ?: $this->getNewModel();

		return $model->getFillable();
	}
}
