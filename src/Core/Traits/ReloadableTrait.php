<?php

namespace PragmaRX\Sdk\Core\Traits;


trait ReloadableTrait {

	public function reload()
	{
		$instance = new static;

		$instance = $instance->newQuery()->find($this->{$this->primaryKey});

		$this->attributes = $instance->attributes;

		$this->original = $instance->original;
	}

} 
