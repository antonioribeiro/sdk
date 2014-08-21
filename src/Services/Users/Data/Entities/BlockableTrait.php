<?php

namespace PragmaRX\SDK\Services\Users\Data\Entities;


trait BlockableTrait {

	/**
	 * @return mixed
	 */
	public function blockages()
	{
		return $this
			->belongsToMany(static::class, 'blockages', 'blocker_id', 'blocked_id')
			->withTimestamps();
	}

	/**
	 * @return mixed
	 */
	public function blockedBy()
	{
		return $this
			->belongsToMany(static::class, 'blockages', 'blocked_id', 'blocker_id')
			->withTimestamps();
	}

	/**
	 * Determine if current user is blocking another user.
	 *
	 * @param User $otherUser
	 * @return bool
	 */
	public function isBlockedBy(User $otherUser)
	{
		$idsWhoOtherUserBlocks = $otherUser->blockages()->lists('blocked_id');

		return in_array($this->id, $idsWhoOtherUserBlocks);
	}

}
