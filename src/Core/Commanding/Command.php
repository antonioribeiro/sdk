<?php

namespace PragmaRX\Sdk\Core\Commanding;

abstract class Command {

	public function getPublicProperties()
	{
		return get_object_vars($this);
	}

} 
