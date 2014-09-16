<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities;

use Cartalyst\Sentinel\Activations\EloquentActivation as CartalystActivation;
use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;

class UserActivation extends CartalystActivation {

	use IdentifiableTrait;

	protected $table = 'activations';

}
