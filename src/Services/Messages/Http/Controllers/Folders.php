<?php

namespace PragmaRX\Sdk\Services\Messages\Http\Controllers;

use PragmaRX\Sdk\Core\Controller;

use PragmaRX\Sdk\Services\Messages\Jobs\AddFolder as AddFolderJob;
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
	    $input = [
            'user' => Auth::user(),
            'folder_name' => $request->get('folder_name')
        ];

		dispatch(AddFolderJob($input));

		Flash::message(t('paragraphs.folder-was-created'));

		return Redirect::back();
	}

	public function validateData(AddFolder $request)
	{
		return $this->success();
	}

}
