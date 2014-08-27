<?php

namespace PragmaRX\Sdk\Services\Files\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class FileName extends Model {

	protected $table = 'files_names';

	protected $fillable = [
		'file_id',
		'name',
	];

}
