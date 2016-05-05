<?php

namespace PragmaRX\Sdk\Services\Kinds\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class Kind extends Model {

	protected $fillable = ['name', 'icon'];

}
