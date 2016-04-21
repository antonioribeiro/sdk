<?php

namespace PragmaRX\Sdk\Services\Files\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Files\Data\Presenters\File as FilePresenter;

class File extends Model
{
	protected $fillable = [
		'directory_id',
		'deep_path',
		'hash',
		'size',
        'width',
        'height',
		'extension',
		'image',
	];

    protected $presenter = FilePresenter::class;
    
	public function directory()
	{
		return $this->belongsTo(
			'PragmaRX\Sdk\Services\Files\Data\Entities\Directory',
			'directory_id'
		);
	}

    public function getUrlAttribute()
    {
        return $this->getUrl();
    }

	public function getUrl()
	{
        $file = sprintf(
            "%s%s/%s.%s",
            $this->directory->relative_path,
            $this->deep_path,
            $this->hash,
            $this->extension
        );

        if (! $this->directory->base_url)
        {
            return asset($file);
        }

        return $this->directory->base_url . $file;
	}

	public function getIsImageAttribute()
	{
		return in_array(
			$this->extension,
			['jpg', 'png', 'jpeg', 'gif', 'bmp', 'webp', 'tiff']
		);
	}
}
