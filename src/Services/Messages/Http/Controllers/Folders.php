<?php

namespace PragmaRX\Sdk\Services\Messages\Http\Controllers;

use PragmaRX\Sdk\Core\Controller;

use PragmaRX\Sdk\Services\Messages\Commands\AddFolderCommand;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;
use PragmaRX\Sdk\Services\Messages\Http\Requests\AddFolder;
use Redirect;
use Auth;
use Flash;

class Folders extends Controller {

	private $messageRepository;

	function __construct(MessageRepository $messageRepository)
	{
		$this->messageRepository = $messageRepository;
	}

	public function index($currentFolder = 'inbox')
	{
		return [
			'folders' => $this->messageRepository->allFoldersCountFor(Auth::user()),
		    'messages' => $this->messageRepository->allFor(Auth::user(), $currentFolder, true)
		];
	}

	public function store(AddFolder $request)
	{
		$thread = $this->execute(
			AddFolderCommand::class,
			[
				'user' => Auth::user(),
				'folder_name' => $request->get('folder_name')
			]
		);

		return Redirect::back();
	}

	public function validate(AddFolder $request)
	{
		return $this->success();
	}

}
