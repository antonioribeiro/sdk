<?php

namespace PragmaRX\SDK\Users;


trait ConnectableTrait {

	/**
	 * @return mixed
	 */
	public function allConnections()
	{
		$relation = $this
			->belongsToMany(static::class, 'connections', 'requestor_id', 'requested_id')
			->withTimestamps();

		// Delete the already built "inner join".
		$relation
			->getQuery() // Eloquent\Builder
			->getQuery() // Query\Builder
			->joins = [];

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

		// Create a new inner join with the needed or condition.
		$relation->getQuery()->getQuery()->join('connections', function($join)
		{
			$join->on('users.id','=','connections.requestor_id');
			$join->orOn('users.id','=','connections.requested_id');
		});

		// Create a new where with both conditions
		$relation->where(function($query)
		{
			$query->where('connections.requestor_id', $this->id);
			$query->orWhere('connections.requested_id', $this->id);
		});

		// A user is not connected to itself
		$relation->where('users.id', '!=', $this->id);

		// Add a distinct on specific column
		$relation->selectRaw('distinct on ("users"."id") "users"."id"');

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
		return $this->allConnections()->where('authorized', false);
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
			$idsWhoOtherUserIsConnected[] = $user->id;
		}

		return in_array($this->id, $idsWhoOtherUserIsConnected);
	}

}
