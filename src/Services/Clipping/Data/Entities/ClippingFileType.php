<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class ClippingFileType extends Model
{
	protected $table = 'clipping_files_types';

	protected $fillable = ['name'];
}
