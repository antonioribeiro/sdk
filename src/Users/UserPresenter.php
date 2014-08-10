<?php

namespace PragmaRX\SDK\Users;

use PragmaRX\SDK\Core\BasePresenter;

class UserPresenter extends BasePresenter {

	/**
	 * Present the link to the user's gravatar.
	 *
	 * @param int $size
	 * @return string
	 */
	public function gravatar($size = 30)
	{
		$email = md5($this->email);

		return "//www.gravatar.com/avatar/{$email}?s={$size}";
	}

	public function followersCount()
	{
		$count = $this->entity->followedBy()->count();

		$plural = str_plural('Follower', $count);

		return "$count $plural";
	}

	public function followingCount()
	{
		$count = $this->entity->following()->count();

		return "$count Following";
	}

	public function statusesCount()
	{
		$count = $this->entity->statuses()->count();

		$plural = str_plural('Status', $count);

		return "$count $plural";
	}
}
