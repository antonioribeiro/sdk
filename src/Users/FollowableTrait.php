<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 04/08/2014
 * Time: 18:21
 */

namespace PragmaRX\SDK\Users;


trait FollowableTrait {

	public function following()
	{
		return $this
				->belongsToMany(static::class, 'follows', 'follower_id', 'followed_id')
				->withTimestamps();
	}

	public function followedBy()
	{
		return $this
				->belongsToMany(static::class, 'follows', 'followed_id', 'follower_id')
				->withTimestamps();
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
