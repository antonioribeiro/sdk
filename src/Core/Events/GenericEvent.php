<?php

namespace PragmaRX\Sdk\Core\Events;

abstract class GenericEvent {

	public $data;

	function __construct($data)
	{
		$this->data = $data;
	}

}
