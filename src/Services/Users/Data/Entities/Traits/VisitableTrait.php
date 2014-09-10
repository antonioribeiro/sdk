<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities\Traits;

use DB;

trait VisitableTrait {

	/**
	 * @return mixed
	 */
	public function profileVisits()
	{
		return $this
			->belongsToMany(static::class, 'profiles_visits', 'visited_id', 'visitor_id')
			->withTimestamps();
	}

	/**
	 * @return mixed
	 */
	public function uniqueProfileVisitsCount()
	{
		return DB::select(DB::raw('
			select
				distinct
				count(*)
				from "users"
				inner join "profiles_visits" on "users"."id" = "profiles_visits"."visited_id"
				where "profiles_visits"."visited_id" = '.$this->id.'
				group by "visited_id","visitor_id"
		'))[0]->count;
	}

}
