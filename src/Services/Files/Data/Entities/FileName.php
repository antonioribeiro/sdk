<?php

namespace PragmaRX\Sdk\Services\Files\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class FileName extends Model {

	protected $table = 'files_names';

	protected $fillable = [
		'file_id',
		'name',
	];

	public function file()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Files\Data\Entities\File');
	}

}
