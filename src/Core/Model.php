<?php

namespace PragmaRX\Sdk\Core;

use PragmaRX\Sdk\Services\Bus\Events\EventGenerator;
use PragmaRX\Sdk\Core\Traits\ReloadableTrait;
use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;
use PragmaRX\Sdk\Services\Presenter\PresentableTrait;

class Model extends Eloquent {

	protected $dates = ['created_at', 'updated_at'];

	use
		EventGenerator,
		PresentableTrait,
		IdentifiableTrait,
		ReloadableTrait;

}
