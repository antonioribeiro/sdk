<?php

namespace PragmaRX\Sdk\Core\Data;

use Config;

class Repository
{
	protected $model = '';

	/**
	 * Find a user by id.
	 *
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
	 */
	public function findById($id)
	{
		return $this
			->call($this->getModel(), 'findOrFail', $id);
	}

	private function call($className, $method = null, $arguments = [])
	{
		return call($this->getClassName($className), $method, $arguments);
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
}
