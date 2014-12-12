<?php

namespace PragmaRX\Sdk\Services\Messages\Http\Controllers;

use PragmaRX\Sdk\Core\Controller;
use PragmaRX\Sdk\Services\Messages\Commands\MoveMessagesCommand;
use PragmaRX\Sdk\Services\Messages\Commands\ReadMessageCommand;
use PragmaRX\Sdk\Services\Messages\Commands\SendMessageCommand;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;
use PragmaRX\Sdk\Services\Connect\Data\Repositories\Connection as ConnectionRepository;

use PragmaRX\Sdk\Services\Messages\Http\Requests\SendMessage;
use Redirect;
use View;
use Auth;
use Flash;
use Input;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Messages extends Controller {

	private $messageRepository;

	/**
	 * @var ConnectionRepository
	 */
	private $connectionRepository;

	function __construct(MessageRepository $messageRepository, ConnectionRepository $connectionRepository)
	{
		$this->messageRepository = $messageRepository;

		$this->connectionRepository = $connectionRepository;
	}

	public function index()
	{
		$folders = $this->messageRepository->allFoldersFor(Auth::user());

		return View::make('messages.index')
				->with('folders', $folders);
	}

	public function messages($folder = 'inbox')
	{
		$threads = $this->messageRepository->allFor(Auth::user(), $folder);

		return View::make('messages.list')
				->with('threads', $threads);
	}

	public function compose($message_id = null)
	{
		$users = $this->connectionRepository->usersConnectedTo(Auth::user());

		if (!$users)
		{
			return View::make('notifications.notification')
				->with('title', t('titles.no-connections'))
				->with('message', t('paragraphs.cannot-send-message-no-connections'))
				->with(
					'buttons', [
						[
							'caption' => t('captions.go-to-connections'),
							'url' => route_ajax('connections')
						]
					]
				);
		}

		$thread = null;

		if ($message_id)
		{
			$thread = $this->messageRepository->getThreadByMessageId($message_id);
		}

		return View::make('messages.compose')
				->with('users', $users)
				->with('answering_message_id', $message_id)
				->with('thread', $thread);
	}

	public function store(SendMessage $request)
	{
		$input = [
			'user' => Auth::user(),
			'thread_id' => $request->get('thread_id'),
			'recipients' => $request->get('recipients'),
			'subject' => $request->get('subject'),
			'body' => $request->get('body'),
			'attachments' => $request->get('attachments'),
		    'answering_message_id' => $request->get('answering_message_id'),
		];

		$this->execute(SendMessageCommand::class, $input);

		Flash::message(t('paragraphs.message-was-sent'));

		return Redirect::route('messages');
	}

	public function validate(SendMessage $request)
	{
		return $this->success();
	}

	public function read($thread_id)
	{
		$thread = $this->execute(
			ReadMessageCommand::class,
			[
				'user' => Auth::user(),
				'thread_id' => $thread_id
			]
		);

		Flash::message(t('paragraphs.folder-was-created'));

		return View::make('messages.show')->with('thread', $thread);
	}

	public function move()
	{
		$messages = Input::get('messages');

		$messages = ! is_array($messages) ? [$messages] : $messages;

		$input = [
			'folder_id' => Input::get('folder_id'),
			'threads_ids' => $messages,
			'user' => Auth::user(),
		];

		$this->execute(MoveMessagesCommand::class, $input);

		return Redirect::back();
	}

}
