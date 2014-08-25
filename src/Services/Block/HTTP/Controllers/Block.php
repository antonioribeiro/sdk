<?php

namespace PragmaRX\SDK\Services\Block\Http\Controllers;

use Auth;
use Flash;
use PragmaRX\SDK\Core\Redirect;
use PragmaRX\SDK\Core\Controller as BaseController;
use PragmaRX\SDK\Services\Block\Commands\BlockUserCommand;
use PragmaRX\SDK\Services\Block\Commands\UnblockUserCommand;

class Block extends BaseController {

	/**
	 * Create a Block instance.
	 *
	 */
	public function __construct()
	{
		$this->beforeFilter('auth');
	}

	/**
	 * Block a user.
	 *
	 * @param $user_to_block
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store($user_to_block)
	{
		$input = ['user_to_block' => $user_to_block, 'user_id' => Auth::id()];

		$this->execute(BlockUserCommand::class, $input);

		Flash::message('You are now blocked to this user.');

		return Redirect::route('profile', ['username' => $user_to_block]);
	}

	/**
	 * Unblock a user.
	 *
	 * @param $user_to_unblock
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($user_to_unblock)
	{
		$input = [
			'user_to_unblock' => $user_to_unblock,
			'user_id' => Auth::id()
		];

		$this->execute(UnblockUserCommand::class, $input);

		Flash::message('You are not blocked to this user anymore.');

		return Redirect::route('profile', ['username' => $user_to_unblock]);
	}
}
