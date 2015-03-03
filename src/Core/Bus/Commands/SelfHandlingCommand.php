<?php

namespace PragmaRX\Sdk\Core\Bus\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use PragmaRX\Sdk\Core\Bus\Events\DispatchableTrait;

abstract class SelfHandlingCommand implements SelfHandling {

	use DispatchableTrait;

}
