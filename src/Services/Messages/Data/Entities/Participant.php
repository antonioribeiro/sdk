<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Participant extends Model {

	protected $table = 'messages_participants';

	protected $fillable = ['thread_id', 'user_id', 'last_read'];

}
