<?php

namespace PragmaRX\Sdk\Services\Activations\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Activation extends Model {

	protected $fillable = ['user_id', 'code', 'completed', 'completed_at'];

}
