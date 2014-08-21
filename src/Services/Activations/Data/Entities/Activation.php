<?php

namespace PragmaRX\SDK\Services\Activations\Data\Entities;

use PragmaRX\SDK\Core\Model;

class Activation extends Model {

	protected $fillable = ['user_id', 'code', 'completed', 'completed_at'];

}
