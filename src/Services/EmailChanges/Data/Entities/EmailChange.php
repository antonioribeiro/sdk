<?php

namespace PragmaRX\Sdk\Services\EmailChanges\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class EmailChange extends Model {

	protected $fillable = ['user_id', 'email', 'token'];

}
