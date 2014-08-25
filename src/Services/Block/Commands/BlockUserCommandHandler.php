<?php

namespace PragmaRX\Sdk\Services\Block\Commands;

use Laracasts\Commander\CommandHandler;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class BlockUserCommandHandler implements CommandHandler{

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
		return $this->userRepository->block($command->user_to_block, $command->user_id);
	}

}
