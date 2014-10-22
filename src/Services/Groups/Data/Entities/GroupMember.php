<?php

namespace PragmaRX\Sdk\Services\Groups\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class GroupMember extends Model {

	protected $table = 'groups_members';

	protected $fillable = ['name', 'owner_id'];

	public static $hasIdColumn = false;

}
