<?php

namespace PragmaRX\SDK\Follow;

use Auth;
use Flash;
use Redirect;
use PragmaRX\SDK\Core\Controller as BaseController;

class Controller extends BaseController {

	/**
	 * Create a Follow instance.
	 *
	 */
	public function __construct()
	{
		$this->beforeFilter('auth');
	}

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

		Flash::message('You are now following this user.');

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

		Flash::message('You are not following this user anymore.');

		return Redirect::route('profile', ['username' => $user_to_unfollow]);
	}
}
