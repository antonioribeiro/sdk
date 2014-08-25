<?php

namespace PragmaRX\Sdk\Services\Follow\Http\Controllers;

use Auth;
use Flash;
use PragmaRX\Sdk\Core\Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Follow\Commands\FollowUserCommand;
use PragmaRX\Sdk\Services\Follow\Commands\UnfollowUserCommand;

class Follow extends BaseController {

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
