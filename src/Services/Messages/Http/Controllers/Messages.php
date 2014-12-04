<?php

namespace PragmaRX\Sdk\Services\Messages\Http\Controllers;

use PragmaRX\Sdk\Core\Controller;
use PragmaRX\Sdk\Services\Messages\Commands\SendMessageCommand;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;
use PragmaRX\Sdk\Services\Connect\Data\Repositories\Connection as ConnectionRepository;

use PragmaRX\Sdk\Services\Messages\Http\Requests\SendMessage;
use Redirect;
use View;
use Auth;
use Flash;

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
		return View::make('messages.index');
	}

	public function messages($folder)
	{
		$threads = $this->messageRepository->allFor(Auth::user());

		return View::make('messages.list')
				->with('threads', $threads);
	}

	public function compose()
	{
		$users = $this->connectionRepository->usersConnectedTo(Auth::user());

		if ( ! $users)
		{
			return View::make('notifications.notification')
					->with('title', t('titles.no-connections'))
					->with('message', t('paragraphs.cannot-send-message-no-connections'))
					->with('buttons', [[
										'caption' => t('captions.go-to-connections'),
					                    'url' => route_ajax('connections')
					                   ]]);
		}

		return View::make('messages.compose')
				->with('users', $users);
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
		];

		$this->execute(SendMessageCommand::class, $input);

		Flash::message(t('paragraphs.message-was-sent'));

		return Redirect::route('messages');
	}

	public function validate(SendMessage $request)
	{
		return $this->success();
	}

}
