<?php

namespace PragmaRX\Sdk\Services\Follow\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Follow\Commands\FollowUserCommand;
use PragmaRX\Sdk\Services\Follow\Commands\UnfollowUserCommand;

use Auth;
use Flash;
use Redirect;

class Follow extends BaseController {

	/**
	 * Follow a user.
	 *
	 * @param $username
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store($user_to_follow)
	{
		$input = ['user_to_follow' => $user_to_follow, 'user_id' => Auth::id()];

		$this->execute(FollowUserCommand::class, $input);

		Flash::message(t('paragraphs.you-are-following'));

		return Redirect::route('profile', ['username' => $user_to_follow]);
	}

	/**
	 * Unfollow a user.
	 *
	 * @param $user_to_unfollow
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($user_to_unfollow)
	{
		$input = [
			'user_to_unfollow' => $user_to_unfollow,
			'user_id' => Auth::id()
		];

		$this->execute(UnfollowUserCommand::class, $input);

		Flash::message(t('paragraphs.you-are-not-following'));

		return Redirect::route('profile', ['username' => $user_to_unfollow]);
	}
}
