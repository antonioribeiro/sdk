<?php

namespace PragmaRX\Sdk\Core;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Presenter\PresentableTrait;
use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;
use PragmaRX\Sdk\Core\Traits\ReloadableTrait;

class Model extends Eloquent {

	use
		EventGenerator,
		PresentableTrait,
		IdentifiableTrait,
		ReloadableTrait;

}
