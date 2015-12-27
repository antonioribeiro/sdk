<?php

namespace PragmaRX\Sdk\Services\Block\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Block\Commands\BlockUserCommand;
use PragmaRX\Sdk\Services\Block\Commands\UnblockUserCommand;

use Auth;
use Flash;
use Redirect;

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
		$input = ['user_to_block' => $user_to_block, 'user_id' => Auth::id()];

		$this->execute(BlockUserCommand::class, $input);

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
		$input = [
			'user_to_unblock' => $user_to_unblock,
			'user_id' => Auth::id()
		];

		$this->execute(UnblockUserCommand::class, $input);

		Flash::message(t('paragraphs.you-are-not-blocking'));

		return Redirect::route('profile', ['username' => $user_to_unblock]);
	}
}
