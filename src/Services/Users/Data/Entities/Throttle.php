<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities;

use Cartalyst\Sentinel\Throttling\EloquentThrottle as CartalystThrottle;
use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;

class Throttle extends CartalystThrottle {

	use IdentifiableTrait;

}
