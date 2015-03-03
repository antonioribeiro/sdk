<?php

namespace PragmaRX\Sdk\Core\Bus\Commands;

use PragmaRX\Sdk\Core\Bus\Events\DispatchableTrait;

abstract class Command {

	use DispatchableTrait;

	public function getPublicProperties()
	{
		return get_object_vars($this);
	}

}
