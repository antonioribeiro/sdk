<?php

namespace PragmaRX\Sdk\Services\Files\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Services\Files\Data\Repositories\File as FileRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class UploadFileCommandHandler extends CommandHandler {

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
