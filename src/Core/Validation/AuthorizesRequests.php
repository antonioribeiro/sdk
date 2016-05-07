<?php

namespace PragmaRX\Sdk\Core\Validation;

use Illuminate\Contracts\Auth\Access\Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait AuthorizesRequests
{
	public function checkGateAuthorization($ability, $arguments = [])
	{
		if (! app(Gate::class)->check($ability, $arguments)) {
			throw $this->createGateUnauthorizedException($ability, $arguments);
		}
	}

	public function checkAuthorizationForUser($user, $ability, $arguments = [])
	{
		list($ability, $arguments) = $this->parseAbilityAndArguments($ability, $arguments);

		$result = app(Gate::class)->forUser($user)->check($ability, $arguments);

		if (! $result) {
			throw $this->createGateUnauthorizedException($ability, $arguments);
		}
	}

	protected function parseAbilityAndArguments($ability, $arguments)
	{
		if (is_string($ability)) {
			return [$ability, $arguments];
		}

		return [debug_backtrace(false, 3)[2]['function'], $ability];
	}

	protected function createGateUnauthorizedException($ability, $arguments)
	{
		return app()->make(HttpException::class, [403, 'This action is unauthorized.']);
	}
}
