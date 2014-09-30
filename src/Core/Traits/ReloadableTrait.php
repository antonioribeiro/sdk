<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 24/09/2014
 * Time: 23:51
 */

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
