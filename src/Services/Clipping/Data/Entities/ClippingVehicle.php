<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ClippingVehicle extends Model
{
	protected $table = 'clipping_vehicles';

	protected $fillable = ['name'];
}
