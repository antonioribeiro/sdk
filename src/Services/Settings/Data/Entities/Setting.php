<?php

namespace PragmaRX\Sdk\Services\Settings\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class Setting extends Model {

	public static $generateId = false;

	protected $table = 'users_settings';

	protected $fillable = ['requested_id', 'requestor_id'];

}
