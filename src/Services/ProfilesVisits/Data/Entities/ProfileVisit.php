<?php

namespace PragmaRX\Sdk\Services\ProfilesVisits\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use Session;

class ProfileVisit extends Model {

	public static $generateId = false;

	protected $table = 'profiles_visits';

	protected $fillable = ['visitor_id', 'visited_id', 'session_id'];

	public static function visit($data = [])
	{
		$session_id = Session::getId();

		$visit = static::where('visitor_id', $data['visitor_id'])
							->where('visited_id', $data['visited_id'])
							->where('session_id', $session_id)
							->first();

		if ( ! $visit)
		{
			$data['session_id'] = $session_id;

			return static::create($data);
		}

		return $visit;
	}

}
