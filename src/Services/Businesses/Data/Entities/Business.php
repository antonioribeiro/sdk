<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Business extends Model
{
	protected $table = 'businesses';

	protected $fillable = [
		'name',
	];
}
