<?php

namespace PragmaRX\Sdk\Services\Groups\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class GroupRole extends Model {

	protected $table = 'groups_roles';

	protected $fillable = ['name'];

	public static function ownerId()
	{
		return static::owner()->id;
	}

	public static function owner()
	{
		return static::where('name', 'owner')->first();
	}

	public static function administratorId()
	{
		return static::administrator()->id;
	}

	public static function administrator()
	{
		return static::where('name', 'administrator')->first();
	}

	public static function memberId()
	{
		return static::member()->id;
	}

	public static function member()
	{
		return static::where('name', 'member')->first();
	}

}
