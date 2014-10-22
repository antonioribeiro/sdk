<?php

namespace PragmaRX\Sdk\Services\Groups\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Group extends Model {

	protected $fillable = ['name', 'owner_id'];

	public function owner()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User', 'owner_id');
	}

}
