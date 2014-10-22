<?php

namespace PragmaRX\Sdk\Services\Groups\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class GroupRole extends Model {

	protected $table = 'groups_roles';

	protected $fillable = ['name'];

}
