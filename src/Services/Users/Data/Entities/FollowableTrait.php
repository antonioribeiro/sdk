<?php

namespace PragmaRX\SDK\Services\Users\Data\Entities;


trait FollowableTrait {

	/**
	 * @return mixed
	 */
	public function following()
	{
		$relation = $this
					->belongsToMany(static::class, 'follows', 'follower_id', 'followed_id')
					->withTimestamps();

		$this->filterRelationBlockages($relation, 'followed_id', 'follower_id');

		return $relation;
	}

	public function followedBy()
	{
		$relation = $this
					->belongsToMany(static::class, 'follows', 'followed_id', 'follower_id')
					->withTimestamps();

		$this->filterRelationBlockages($relation, 'followed_id', 'follower_id');

		if ($blocked = $this->blockages()->lists('blocked_id'))
		{
			$relation->whereNotIn('follower_id', $blocked);
		}

		return $relation;
	}

	/**
	 * Determine if current user follows another user.
	 *
	 * @param User $otherUser
	 * @return bool
	 */
	public function isFollowedBy(User $otherUser)
	{
		$idsWhoOtherUserFollows = $otherUser->following()->lists('followed_id');

		return in_array($this->id, $idsWhoOtherUserFollows);
	}

}
