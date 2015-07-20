<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Tags\Data\Entities\Tag;

class Clipping extends Model
{
	protected $table = 'clipping';

	protected $dates = ['created_at', 'updated_at', 'published_at'];

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
