<?php

namespace PragmaRX\Sdk\Services\Bus\Commands;

use PragmaRX\Sdk\Services\Bus\Events\DispatchableTrait;

abstract class Command
{
	use DispatchableTrait;

	public function getPublicProperties()
	{
		return get_object_vars($this);
	}
}
