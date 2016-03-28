<?php

namespace PragmaRX\Sdk\Services\Groups\Data\Entities;

use Illuminate\Support\Collection;
use PragmaRX\Sdk\Core\Model;

class Group extends Model
{
	protected $fillable = ['name'];

	public function associations()
	{
		return $this->hasMany('PragmaRX\Sdk\Services\Groups\Data\Entities\GroupMember', 'group_id');
	}

	public function memberships()
	{
		return $this->morphMany('PragmaRX\Sdk\Services\Groups\Data\Entities\GroupMember', 'membership');
	}

	public function getMembersAttribute()
	{
		$members = $this
					->getAssociations(
						$this->associations()
							->where('group_role_id', GroupRole::memberId())->get()
					);

		return new Collection($members);
	}

	public function getAdministratorsAttribute()
	{
		$members = $this
					->getAssociations(
						$this->associations()
							->where('group_role_id', GroupRole::administratorId())->get()
					);

		return new Collection($members);
	}

	public function getOwnerAttribute()
	{
		$owner = $this
					->associations()
					->where('group_role_id', GroupRole::ownerId())->first();

		return $owner->membership;
	}

	private function getAssociations($associations)
	{
		$members = [];

		foreach($associations as $association)
		{
			if ($association->membership instanceof Group)
			{
				$members = $members + $this->getAssociations($association->membership->associations);
			}
			else
			{
				$members = array_merge($members, [$association->membership]);
			}
		}

		return $members;
	}

	public function selectAvailableUsersAndGroupsFor($user)
	{
		$subjects = [];

		foreach($user->getUsersConnectedToMe()->diff($this->members) as $subject)
		{
			$subjects['user#'.$subject->id] = $subject->present()->fullName;
		}

		return $subjects;
	}

	public function isManagedBy($user_id)
	{
		return $this->associations()
				->where('membership_id', $user_id)
				->where(function($query) use ($user_id)
					{
						$query->where('group_role_id', GroupRole::ownerId());
						$query->orWhere('group_role_id', GroupRole::administratorId());
					})
				->first();
	}
}
