<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class SystemFolder extends Model {

	protected $table = 'messages_system_folders';

	protected $fillable = ['name', 'user_id'];

}
