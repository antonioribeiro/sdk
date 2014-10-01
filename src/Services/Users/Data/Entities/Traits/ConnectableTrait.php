<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities\Traits;

use PragmaRX\Sdk\Services\Users\Data\Entities\User;

trait ConnectableTrait {

	/**
	 * @return mixed
	 */
	public function allConnections()
	{
		$relation = $this
			->hasMany(
				'PragmaRX\Sdk\Services\Connect\Data\Entities\Connection',
				'requestor_id',
				'id'
			)
			->orWhere('requested_id', $this->id);

//		// Delete the already built "inner join".
//		$relation
//			->getQuery() // Eloquent\Builder
//			->getQuery() // Query\Builder
//			->joins = [];

		// Delete the already built "where".
		$relation
			->getQuery()
			->getQuery()
			->wheres = [];

		// Delete all bindings.
		$relation
			->getQuery()
			->getQuery()
			->setBindings([]);

//		// Create a new inner join with the needed or condition.
//		$relation->getQuery()->getQuery()->join('connections as requestor_connections', function($join)
//		{
//			$join->on('users.id','=','requestor_connections.requestor_id');
//			$join->orOn('users.id','=','requestor_connections.requested_id');
//		});
//
//		// Create a new where with both conditions
//		$relation->where(function($query)
//		{
//			$query->where('connections.requestor_id', $this->id);
//			$query->orWhere('connections.requested_id', $this->id);
//		});

		// Create a new where with both conditions
		$relation->where(function($query)
		{
			$query->where('connections.requestor_id', $this->id);
			$query->orWhere('connections.requested_id', $this->id);
		});


//		// A user is not connected to itself
//		$relation->where('users.id', '!=', $this->id);
//
//		// Add a distinct on specific column
//		$relation->selectRaw('distinct on ("users"."id") *');

		$this->filterRelationBlockages($relation, 'requested_id', 'requestor_id');

		return $relation;
	}

	/**
	 * @return mixed
	 */
	public function connections()
	{
		return $this->allConnections()->where('authorized', true);
	}

	/**
	 * @return mixed
	 */
	public function pendingConnections()
	{
		return $this->allConnections()
				->where('authorized', false)
				->where('connections.requestor_id', '!=', $this->id);
	}

	/**
	 * Determine if current user is connected to another user.
	 *
	 * @param User $otherUser
	 * @return bool
	 */
	public function isConnectedTo(User $otherUser)
	{
		$usersWhoOtherUserIsConnected = $otherUser
										->connections()
										->get();

		return $this->userIdIsInList($usersWhoOtherUserIsConnected);
	}

	/**
	 * Determine if current user is connected or has a connection pending with another user.
	 *
	 * @param User $otherUser
	 * @return bool
	 */
	public function isConnectedOrIsPendingTo(User $otherUser)
	{
		$usersWhoOtherUserIsConnected = $otherUser
										->allConnections()
										->get();

		return $this->userIdIsInList($usersWhoOtherUserIsConnected);
	}

	/**
	 * Determine if a connection for the current user is pending to another user.
	 *
	 * @param User $otherUser
	 * @return bool
	 */
	public function hasPendingConnectionTo(User $otherUser)
	{
		$usersWhoOtherUserIsConnected = $otherUser
										->pendingConnections()
										->get();

		return $this->userIdIsInList($usersWhoOtherUserIsConnected);
	}

	/**
	 * @param $users
	 * @return bool
	 */
	private function userIdIsInList($users)
	{
		$idsWhoOtherUserIsConnected = [];

		foreach ($users as $user)
		{
			$idsWhoOtherUserIsConnected[] = $user->requestor_id == $this->id ? $user->requestor_id : $user->requested_id;
		}

		return in_array($this->id, $idsWhoOtherUserIsConnected);
	}

	public function pendingConnectionTo($user_id)
	{
		return $this->allConnections()
			->where('authorized', false)
			->where('connections.requested_id', '=', $this->id)
			->where('connections.requestor_id', '=', $user_id)
			->first();
	}

	public function getConnectionTo($user_id)
	{
		$user = $this;

		return $this->allConnections()
			->where('authorized', true)
			->where(function($query) use ($user, $user_id)
			{
				$query->where(function($query) use ($user, $user_id)
				{
					$query->where('connections.requestor_id', '=', $this->id);
					$query->Where('connections.requested_id', '=', $user_id);
				});

				$query->orWhere(function($query) use ($user, $user_id)
				{
					$query->where('connections.requestor_id', '=', $user_id);
					$query->Where('connections.requested_id', '=', $this->id);
				});
			})
			->first();
	}

}
