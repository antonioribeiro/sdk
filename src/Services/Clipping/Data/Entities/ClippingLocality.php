<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class ClippingLocality extends Model
{
	protected $table = 'clipping_localities';

	protected $fillable = ['name'];
}
