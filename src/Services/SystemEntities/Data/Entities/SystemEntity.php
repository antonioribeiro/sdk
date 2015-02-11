<?php

namespace PragmaRX\Sdk\Services\SystemClass\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class SystemEntity extends Model {

	protected $table = 'system_entities';

	protected $fillable = [
		'name',
	    'class'
	];

}
