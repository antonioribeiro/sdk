<?php

namespace PragmaRX\Sdk\Services\Activation\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Activation extends Model {

	protected $fillable = [
		'user_id',
		'code',
	];

	public static function createFor($user)
	{
		$activation = static::create([
			'user_id' => $user->id,
			'code' => uuid(),
		]);

		return $activation;
	}

}
