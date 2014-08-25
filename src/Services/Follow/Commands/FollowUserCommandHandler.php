<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 29/07/2014
 * Time: 20:13
 */

namespace PragmaRX\Sdk\Services\Follow\Commands;

use Laracasts\Commander\CommandHandler;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class FollowUserCommandHandler implements CommandHandler{

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
		return $this->userRepository->follow($command->user_to_follow, $command->user_id);
	}

}
