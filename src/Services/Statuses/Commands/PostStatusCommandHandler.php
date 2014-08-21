<?php

namespace PragmaRX\SDK\Services\Statuses\Commands;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use PragmaRX\SDK\Services\Statuses\Data\Entities\Status;
use PragmaRX\SDK\Services\Statuses\Data\Repositories\StatusRepository;

class PostStatusCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $repository;

	function __construct(StatusRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 * @return mixed
	 */
	public function handle($command)
	{
		$status = Status::publish($command->body);

		$this->repository->save($status, $command->user_id);

		$this->dispatchEventsFor($status);

		return $status;
	}
}
