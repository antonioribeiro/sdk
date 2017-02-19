<?php

namespace PragmaRX\Sdk\Services\Config\Service;

use ArrayAccess;

class Config implements ArrayAccess {

	protected $packages = [];

	public function __construct()
	{
	    $this->config = app('config');
	}

	public function get($key, $default = null)
	{
		$keys = [];

		list($namespace, $key) = $this->explodeKey($key);

		if ($namespace)
		{
			$keys = $this->loadPackageConfig($namespace);
		}

		if ( ! $keys)
		{
			// Use Laravel's config
			return $this->config->get($key, $default);
		}

		if ($keys && is_array($keys))
		{
			$keys = array_get($keys, $key, $default);
		}

		return $keys;
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(
			array($this->config, $name),
			$arguments
		);
	}

	private function explodeKey($key)
	{
		$exploded = explode('::', $key);

		if (count($exploded) == 1)
		{
			$exploded = ['', $exploded[0]];
		}

		return $exploded;
	}

	private function loadPackageConfig($namespace)
	{
		if (isset($this->packages[$namespace]))
		{
			return $this->packages[$namespace];
		}

		$paths = [
			base_path().
				DIRECTORY_SEPARATOR.'config'.
				DIRECTORY_SEPARATOR.'packages'.
				DIRECTORY_SEPARATOR.$namespace.
				DIRECTORY_SEPARATOR.'config.php',

			base_path().
				DIRECTORY_SEPARATOR.'vendor'.
				DIRECTORY_SEPARATOR.$namespace.
				DIRECTORY_SEPARATOR.'src'.
				DIRECTORY_SEPARATOR.'config'.
				DIRECTORY_SEPARATOR.'config.php',
		];

		foreach($paths as $path)
		{
			if (file_exists($path))
			{
				$keys = require $path;

				$this->packages[$namespace] = $keys;

				return $keys;
			}
		}
	}

	public function offsetExists($key)
	{
		return $this->has($key);
	}

	public function offsetGet($key)
	{
		return $this->get($key);
	}

	public function offsetSet($key, $value)
	{
		$this->set($key, $value);
	}

	public function offsetUnset($key)
	{
		$this->set($key, null);
	}

	public function package($a, $b = null, $c = null, $e = null)
	{
		return $a = $b;
	}

}
