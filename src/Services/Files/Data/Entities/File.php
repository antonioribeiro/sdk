<?php

namespace PragmaRX\Sdk\Services\Files\Data\Entities;

use Laracasts\Commander\Events\EventGenerator;
use PragmaRX\Sdk\Core\Model;

class File extends Model {

	use EventGenerator;

	protected $fillable = [
		'directory_id',
		'deep_path',
		'hash',
		'extension',
		'image',
	];

	public function directory()
	{
		return $this->belongsTo(
			'PragmaRX\Sdk\Services\Files\Data\Entities\Directory',
			'directory_id'
		);
	}

	public function getUrl()
	{
		return asset(sprintf(
			"%s%s/%s.%s",
			$this->directory->relative_path,
			$this->deep_path,
			$this->hash,
			$this->extension
		));
	}
}
