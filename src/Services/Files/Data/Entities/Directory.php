<?php

namespace PragmaRX\Sdk\Services\Files\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class Directory extends Model {

	protected $fillable = [
		'host',
		'path',
		'relative_path',
        'base_url',
	];

}
