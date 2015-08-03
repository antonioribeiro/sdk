<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Tags\Data\Entities\Tag;

class Clipping extends Model
{
	protected $table = 'clipping';

	protected $dates = ['created_at', 'updated_at', 'published_at'];

	protected $presenter = 'PragmaRX\Sdk\Services\Clipping\Data\Presenters\Clipping';

	protected $fillable = [
		'heading',
		'subheading',
		'body',
		'author_id',
		'vehicle_id',
		'category_id',
		'locality_id',
		'url',
		'article_preview_url',
		'published_at',
	];

	public function author()
	{
		return $this->belongsTo(ClippingAuthor::class, 'author_id');
	}

	public function category()
	{
		return $this->belongsTo(ClippingCategory::class, 'category_id');
	}

	public function files()
	{
		return $this->hasMany(ClippingFile::class);
	}

	public function mainFile()
	{
		return $this->files()->where('clipping_files.is_main', true)->first();

	}

	public function snapshotFile()
	{
		return $this->files()->where('clipping_files.is_snapshot', true)->first();
	}

	public function locality()
	{
		return $this->belongsTo(ClippingLocality::class, 'locality_id');
	}

	public function vehicle()
	{
		return $this->belongsTo(ClippingVehicle::class, 'vehicle_id');
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class, 'clipping_tags');
	}
}
