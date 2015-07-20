<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Clipping extends Model
{
	protected $table = 'clipping';

	protected $dates = ['created_at', 'updated_at', 'published_at'];

	public function author()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingAuthor', 'author_id');
	}

	public function category()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingCategory', 'category_id');
	}

	public function files()
	{
		return $this->hasMany('PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingFile');
	}

	public function locality()
	{
		return $this->hasMany('PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingLocality', 'locality_id');
	}

	public function vehicle()
	{
		return $this->hasMany('PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingVehicle', 'vehicle_id');
	}
}
