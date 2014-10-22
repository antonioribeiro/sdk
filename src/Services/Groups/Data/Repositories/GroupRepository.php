<?php

namespace PragmaRX\Sdk\Services\Groups\Data\Repositories;

use PragmaRX\Sdk\Services\Groups\Data\Entities\Group;
use PragmaRX\Sdk\Services\Groups\Data\Entities\GroupMember;
use PragmaRX\Sdk\Services\Groups\Data\Entities\GroupRole;

class GroupRepository {

	public function getAllFrom($user)
	{
		return $user->groups();
	}

	public function getConnectionsAndGroups($user)
	{
		return [
			'user#id1' => 'Aline Amorim',
			'user#id2' => 'Hugo Elídio',
			'user#id3' => 'Graça Gouvea',
			'group#id3' => 'Administradores',
		];
	}

	public function addGroup($user, $name, $members)
	{
		$group = Group::create([
			'name' => $name,
	        'owner_id' => $user->id,
		]);

		$this->addMembersToGroup($group, $members);

		return $user;
	}

	private function addMembersToGroup($group, $members)
	{
		$roleMember = GroupRole::where('name', 'member')->first();

		foreach($members as $member)
		{
			list($kind, $id) = explode('#', $member);

			$groupMember = new GroupMember;

			$groupMember->group_id = $group->id;

			$groupMember->{"member_{$kind}_id"} = $id;

			$groupMember->group_role_id = $roleMember->id;

			$groupMember->save();
		}
	}

}
