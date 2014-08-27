<?php

namespace PragmaRX\Sdk\Services\Avatars\Service;

use PragmaRX\Sdk\Services\Users\Data\Entities\User;
use File;

class Avatar {

	/**
	 * Get avatar URL.
	 *
	 * @param User $user
	 * @param int $size
	 * @return string
	 */
	public function getUrl(User $user, $size = 30)
	{
		if ( ! $user->avatar_id)
		{
			return $this->getGravatarUrl($user->email, $size);
		}

		return $this->getFileUrl($user->avatar_id, $size);
	}

	/**
	 * Get Gravatar URL.
	 *
	 * @param $email
	 * @param int $size
	 * @return string
	 */
	public function getGravatarUrl($email, $size = 30)
	{
		$email = md5($email);

		return "//www.gravatar.com/avatar/{$email}?s={$size}&d=identicon";
	}

	/**
	 * Get file URL.
	 *
	 * @param $file_id
	 * @param int $size|null
	 * @return mixed
	 */
	private function getFileUrl($file_id, $size = null)
	{
		return File::getImageUrl($file_id, $size);
	}

}
