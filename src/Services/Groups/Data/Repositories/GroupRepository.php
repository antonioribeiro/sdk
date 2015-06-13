<?php

namespace PragmaRX\Sdk\Services\Groups\Data\Repositories;

use Illuminate\Database\Eloquent\Collection;
use PragmaRX\Sdk\Core\Exceptions\ForbiddenRequest;
use PragmaRX\Sdk\Services\Groups\Data\Entities\Group;
use PragmaRX\Sdk\Services\Groups\Data\Entities\GroupMember;
use PragmaRX\Sdk\Services\Groups\Data\Entities\GroupRole;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class GroupRepository {

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function getGroupsFrom($subject)
	{
		$groups = [];

		foreach($subject->memberships as $membership)
		{
			$groups = array_merge($groups, [$membership->group]);
		}

		return new Collection($groups);
	}

	public function getConnectionsAndGroups($user)
	{
		$connections = $this->getUserConnectionsForSelect($user);

		return $connections;
	}

	public function addGroup($user, $name, $members)
	{
		$group = Group::create(['name' => $name]);

		// Owner
		$role = GroupRole::where('name', 'owner')->first();

		$this->addMember($group, 'user', $user->id, $role);

		// Members
		$role = GroupRole::where('name', 'member')->first();

		$this->addMembers($group, $members, $role);

		return $user;
	}

	private function addMembers($group, $members, $role)
	{
		$result = [];

		$members = $members ?: [];

		foreach($members as $member)
		{
			list($kind, $member_id) = explode('#', $member);

			$result[] = $this->addMember($group, $kind, $member_id, $role);
		}

		return $result;
	}

	public function deleteGroup($group_id, $user)
	{
		if ( ! $this->isGroupManager($group_id, $user))
		{
			throw new ForbiddenRequest(t('paragraphs.forbidden'));
		}

		$group = Group::find($group_id);

		$group->delete();

		return $group;
	}

	private function getUserConnectionsForSelect($user)
	{
		$connections = [];

		foreach($this->userRepository->getUserConnections($user) as $connection)
		{
			$connections['user#'.$connection->id] = $connection->present()->fullName;
		}

		return $connections;
	}

	/**
	 * @param $group
	 * @param $member_id
	 * @param $kind
	 * @param $role
	 */
	public function addMember($group, $kind, $member_id, $role)
	{
		if ($role instanceof GroupRole)
		{
			$role = $role->id;
		}

		$membership = new GroupMember;

		$membership->group_id = $group->id;
		$membership->group_role_id = $role;

		if ($kind == 'user')
		{
			$subject = $this->userRepository->findById($member_id);
		}
		else
		{
			$subject = Group::find($member_id);
		}

		return $subject->memberships()->save($membership);
	}

	public function addMembersToGroup($group_id, $members)
	{
		$group = $this->findById($group_id);

		$members = $this->addMembers($group, $members, GroupRole::member());

		return $members;
	}

	private function findById($group_id)
	{
		return Group::find($group_id);
	}

	public function updateGroup($user, $name, $group_id, $members, $administrators)
	{
		$group = $this->findById($group_id);

		$group->name = $name;

		$group->save();

		$this->updateMembers($group, $members, $administrators);

		return $group;
	}

	private function updateMembers($group, $members, $administrators)
	{
		foreach($members as $member_id => $value)
		{
			$this->updateGroupMember($group, $member_id, GroupRole::memberId());
		}

		foreach($administrators as $member_id => $value)
		{
			$this->updateGroupMember($group, $member_id, GroupRole::administratorId());
		}
	}

	private function updateGroupMember($group, $member_id, $role_id)
	{
		GroupMember::where('group_id', $group->id)
						->where('membership_id', $member_id)
						->update(['group_role_id' => $role_id]);
	}

	public function deleteGroupMembers($group_id, $user, $members, $administrators)
	{
		$this->deleteMembers($group_id, $members);

		$this->deleteMembers($group_id, $administrators);

		return $this->findById($group_id);
	}

	/**
	 * @param $group_id
	 * @param $members
	 * @return int|string
	 */
	private function deleteMembers($group_id, $members)
	{
		foreach ($members as $member_id => $value)
		{
			GroupMember::where('group_id', $group_id)
							->where('membership_id', $member_id)
							->delete();
		}
	}

	private function getManagers($group, $only = null)
	{
		if ( ! $group instanceof Group)
		{
			$group = $this->findById($group);
		}

		$associations = $group
							->associations()
							->where(function($query) use ($only)
							{
								if ($only !== 'administrator')
								{
									$query->where('group_role_id', GroupRole::ownerId());
								}

								if ($only !== 'owner')
								{
									$query->orWhere('group_role_id', GroupRole::administratorId());
								}
							})
							->get();

		$members = [];

		foreach ($associations as $association)
		{
			$members[] = $association->membership;
		}

		return new Collection($members);
	}

	public function isGroupManager($group_id, $user)
	{
		$managers = $this->getManagers($group_id)->lists('id')->toArray();

		return in_array($user->id, $managers);
	}

	public function isGroupOwner($group_id, $user)
	{
		$managers = $this->getManagers($group_id, 'owner')->lists('id')->toArray();

		return in_array($user->id, $managers);
	}

}
