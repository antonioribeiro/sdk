<?php

namespace PragmaRX\Sdk\Services\Block\Http\Controllers;

use Auth;
use Flash;
use Redirect;
use PragmaRX\Sdk\Services\Block\Jobs\BlockUser;
use PragmaRX\Sdk\Services\Block\Jobs\UnblockUser;
use PragmaRX\Sdk\Core\Controller as BaseController;

class Block extends BaseController {

	/**
	 * Create a Block instance.
	 *
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Block a user.
	 *
	 * @param $user_to_block
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store($user_to_block)
	{
		dispatch(new BlockUser($user_to_block, Auth::id()));

		Flash::message(t('paragraphs.you-are-blocking'));

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
		dispatch(new UnblockUser($user_to_unblock, Auth::id()));

		Flash::message(t('paragraphs.you-are-not-blocking'));

		return Redirect::route('profile', ['username' => $user_to_unblock]);
	}
}
