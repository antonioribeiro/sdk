<?php

namespace PragmaRX\Sdk\Services\Files\Commands;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Services\Files\Repositories\File as FileRepository;

class UploadFileCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $repository;

	/**
	 * @var FileRepository
	 */
	private $fileRepository;

	function __construct(UserRepository $repository, FileRepository $fileRepository)
	{
		$this->repository = $repository;

		$this->fileRepository = $fileRepository;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 * @return mixed
	 */
	public function handle($command)
	{
		return $this->fileRepository->upload($command->file, $command->user);
	}
}
