<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class ClippingVehicle extends Model
{
	protected $table = 'clipping_vehicles';

	protected $fillable = ['name'];
}
