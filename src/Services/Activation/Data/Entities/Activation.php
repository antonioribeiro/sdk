<?php

namespace PragmaRX\Sdk\Services\Activation\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Activation extends Model {

	protected $fillable = [
		'items_entity_id',
	];

	public static function createFor($user)
	{
		return static::create([
			'user_id' => $user->id,
			'code' => uuid(),
		]);
	}

}
