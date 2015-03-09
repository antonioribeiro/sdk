<?php

namespace PragmaRX\Sdk\Services\Statuses\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Statuses\Data\Entities\Status;
use PragmaRX\Sdk\Services\Statuses\Data\Repositories\StatusRepository;

class PostStatusCommand extends SelfHandlingCommand {

	public $body;

	public $user_id;

	function __construct($body, $user_id)
	{
		$this->body = $body;

		$this->user_id = $user_id;
	}

	public function handle(StatusRepository $repository)
	{
		$status = Status::publish($this->body);

		$repository->save($status, $this->user_id);

		$this->dispatchEventsFor($status);

		return $status;
	}

}
