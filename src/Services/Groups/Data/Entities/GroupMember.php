<?php

namespace PragmaRX\Sdk\Services\Groups\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class GroupMember extends Model {

	protected $table = 'groups_members';

	protected $fillable = ['name', 'group_id', 'group_role_id', 'member_id', 'member_type'];

	public function membership()
	{
		return $this->morphTo();
	}

	public function group()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Groups\Data\Entities\Group');
	}

}

