<?php

namespace PragmaRX\Sdk\Services\Bus\Service;

use ArrayAccess;
use ReflectionClass;
use ReflectionProperty;
use ReflectionParameter;
use Illuminate\Bus\Dispatcher as IlluminateDispatcher;

class Dispatcher extends IlluminateDispatcher {

	protected function marshal($command, ArrayAccess $source, array $extras = [])
	{
		$reflection = new ReflectionClass($command);

		if ( ! $constructor = $reflection->getConstructor())
		{
			$instance = $reflection->newInstanceWithoutConstructor();

			foreach($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $parameter)
			{
				$instance->{$parameter->name} = $this->getParameterValueForCommand_Overloaded($command, $source, $parameter, $extras);
			}

			return $instance;
		}

		$injected = array_map(function($parameter) use ($command, $source, $extras)
		{
			return $this->getParameterValueForCommand_Overloaded($command, $source, $parameter, $extras);
		}, $constructor->getParameters());

		return $reflection->newInstanceArgs($injected);
	}

	protected function getParameterValueForCommand_Overloaded($command, ArrayAccess $source,
	                                               $parameter, array $extras = array())
	{
		if (array_key_exists($parameter->name, $extras))
		{
			return $extras[$parameter->name];
		}

		if (isset($source[$parameter->name]))
		{
			return $source[$parameter->name];
		}

		if ($parameter instanceof ReflectionParameter && $parameter->isDefaultValueAvailable())
		{
			return $parameter->getDefaultValue();
		}

		throw new \Exception("Unable to map parameter [{$parameter->name}] to command [{$command}]");
	}

}
