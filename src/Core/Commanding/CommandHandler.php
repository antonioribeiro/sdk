<?php

namespace PragmaRX\Sdk\Core\Commanding;

use Laracasts\Commander\CommandHandler as LaracastsCommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

abstract class CommandHandler implements LaracastsCommandHandler {

	use DispatchableTrait;

} 
