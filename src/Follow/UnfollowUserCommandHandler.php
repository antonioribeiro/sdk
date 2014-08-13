<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 29/07/2014
 * Time: 20:13
 */

namespace PragmaRX\SDK\Follow;

use Laracasts\Commander\CommandHandler;
use PragmaRX\SDK\Users\UserRepository;

class UnfollowUserCommandHandler implements CommandHandler {

	protected $userRepository;

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 * @return mixed
	 */
	public function handle($command)
	{
		return $this->userRepository->unfollow($command->user_to_unfollow, $command->user_id);
	}

}
