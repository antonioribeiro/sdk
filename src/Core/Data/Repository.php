<?php

namespace PragmaRX\Sdk\Core\Data;

use Config;

class Repository
{
	protected $model = '';

	public function findById($id)
	{
		return $this
			->call($this->getModel(), 'findOrFail', $id);
	}

	public function getModel()
	{
		return $this->model;
	}

	public function getNewModel()
	{
		$model = $this->getModel();

		return new $model;
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
}
