<?php

namespace PragmaRX\Sdk\Services\Files\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class File extends Model {

	protected $fillable = [
		'directory_id',
		'deep_path',
		'hash',
		'size',
		'extension',
		'image',
	];

	protected $presenter = 'PragmaRX\Sdk\Services\Files\Data\Presenters\File';

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

	public function getIsImageAttribute()
	{
		return in_array(
			$this->extension,
			['jpg', 'png', 'jpeg', 'gif', 'bmp', 'webp', 'tiff']
		);
	}

}
