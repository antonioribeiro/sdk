<?php

namespace PragmaRX\SDK\Services\EmailChanges\Data\Entities;

use PragmaRX\SDK\Core\Model;

class EmailChange extends Model {

	protected $fillable = ['user_id', 'email', 'token'];

}
