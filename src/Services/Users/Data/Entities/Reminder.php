<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities;

use Cartalyst\Sentinel\Reminders\EloquentReminder as CartalystReminder;
use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;

class Reminder extends CartalystReminder {

	use IdentifiableTrait;

}
