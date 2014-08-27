<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class UserFile extends Model {

	protected $table = 'users_files';

	protected $fillable = [
		'file_name_id',
		'user_id',
	];

}
