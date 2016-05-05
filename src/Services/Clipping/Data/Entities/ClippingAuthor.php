<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class ClippingAuthor extends Model
{
	protected $table = 'clipping_authors';

	protected $fillable = ['name'];
}
