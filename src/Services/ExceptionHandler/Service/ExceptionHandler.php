<?php

namespace PragmaRX\Sdk\Services\ExceptionHandler\Service;

use Closure;
use ReflectionFunction;
use Exception as PHPException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionHandler {

	private $debug = false;

	private $handlers = [];

	public function addHandler(Closure $closure)
	{
		$this->handlers[] = $closure;
	}

	public function handle(PHPException $exception, $fromConsole = false)
	{
		foreach ($this->handlers as $handler)
		{
			// If this exception handler does not handle the given exception, we will just
			// go the next one. A handler may type-hint an exception that it handles so
			//  we can have more granularity on the error handling for the developer.
			if ( ! $this->handlesException($handler, $exception))
			{
				continue;
			}
			elseif ($exception instanceof HttpExceptionInterface)
			{
				$code = $exception->getStatusCode();
			}
			// If the exception doesn't implement the HttpExceptionInterface, we will just
			// use the generic 500 error code for a server side error. If it implements
			// the HttpException interfaces we'll grab the error code from the class.
			else
			{
				$code = 500;
			}
			// We will wrap this handler in a try / catch and avoid white screens of death
			// if any exceptions are thrown from a handler itself. This way we will get
			// at least some errors, and avoid errors with no data or not log writes.
			try
			{
				$response = $handler($exception, $code, $fromConsole);
			}
			catch (\Exception $e)
			{
				$response = $this->formatException($e);
			}
			// If this handler returns a "non-null" response, we will return it so it will
			// get sent back to the browsers. Once the handler returns a valid response
			// we will cease iterating through them and calling these other handlers.
			if (isset($response) && ! is_null($response))
			{
				return $response;
			}
		}
	}

	protected function handlesException(Closure $handler, $exception)
	{
		$reflection = new ReflectionFunction($handler);

		return $reflection->getNumberOfParameters() == 0 || $this->hints($reflection, $exception);
	}

	protected function hints(ReflectionFunction $reflection, $exception)
	{
		$parameters = $reflection->getParameters();

		$expected = $parameters[0];

		return ! $expected->getClass() || $expected->getClass()->isInstance($exception);
	}

	protected function formatException(\Exception $e)
	{
		if ($this->debug)
		{
			$location = $e->getMessage().' in '.$e->getFile().':'.$e->getLine();

			return 'Error in exception handler: '.$location;
		}

		return 'Error in exception handler.';
	}
}
