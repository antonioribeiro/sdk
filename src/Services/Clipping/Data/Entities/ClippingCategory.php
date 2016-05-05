<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class ClippingCategory extends Model
{
	protected $table = 'clipping_categories';

	protected $fillable = ['name'];
}
