<?php

namespace PragmaRX\Sdk\Services\Files\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Files\Data\Repositories\File as FileRepository;

class UploadFile extends Job
{
	public $file;

	public $user;

	public function handle(FileRepository $fileRepository)
	{
		return $fileRepository->upload($this->file, $this->user);
	}
}
