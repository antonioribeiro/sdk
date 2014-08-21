<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 15/07/2014
 * Time: 16:34
 */

namespace PragmaRX\SDK\Services\Statuses\Events;


class StatusWasPublished {

	public $body;

	function __construct($body)
	{
		$this->body = $body;
	}

}
