<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Repositories;

use Carbon\Carbon;
use PragmaRX\Sdk\Services\Messages\Data\Entities\Attachment as AttachmentModel;
use PragmaRX\Sdk\Services\Messages\Data\Entities\Participant as ParticipantModel;
use PragmaRX\Sdk\Services\Messages\Data\Entities\Thread as ThreadModel;
use PragmaRX\Sdk\Services\Messages\Data\Entities\Message as MessageModel;
use PragmaRX\Sdk\Services\Messages\Data\Entities\Folder as FolderModel;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Services\Files\Data\Repositories\File as FileRepository;
use DB;

class Message {

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var FileRepository
	 */
	private $fileRepository;

	public function __construct(UserRepository $userRepository, FileRepository $fileRepository)
	{
		$this->userRepository = $userRepository;

		$this->fileRepository = $fileRepository;
	}

	public function sendMessage(
		$user,
		$thread_id,
		$recipients,
		$subject,
		$body,
		$attachments,
		$answering_message_id
	)
	{
		if ( ! $thread_id && $answering_message_id)
		{
			$message = $this->getMessageById($answering_message_id);

			$thread = $message->thread;
		}
		else
		{
			$thread = $this->findThread($thread_id, $user, $subject, $recipients);
		}

		$message = MessageModel::create([
			'thread_id' => $thread->id,
			'sender_id' => $this->findParticipantByThreadAndUser($thread, $user)->id,
			'body' => $body,
		    'answering_message_id' => $answering_message_id,
		]);

		$this->addAttachmentsToMessage($user, $message, $attachments);

		return $thread;
	}

	private function findThread($thread_id, $user, $subject, $recipients)
	{
		if ( ! $thread_id || ! $thread = ThreadModel::find($thread_id))
		{
			$thread = ThreadModel::create(
				[
					'owner_id' => $user->id,
					'subject' => $subject,
				]
			);

			$this->addParticipantsToMessage($thread, $recipients);

			$this->createParticipant($thread, $user, Carbon::now());
		}

		return $thread;
	}

	private function addParticipantsToMessage($thread, $recipients)
	{
		foreach($recipients as $recipient)
		{
			$this->createParticipant($thread, $recipient);
		}
	}

	private function addAttachmentsToMessage($user, $message, $attachments)
	{
		foreach($attachments as $file)
		{
			if ($file)
			{
				$uploaded = $this->fileRepository->uploadUserFile($file, $user);

				AttachmentModel::create([
                    'message_id' => $message->id,
                    'user_file_id' => $uploaded->id,
                ]);
			}
		}
	}

	private function createParticipant($thread, $recipient, $lastRead = null)
	{
		if (is_object($recipient))
		{
			$recipient = $recipient->id;
		}

		$participant = ParticipantModel::where('thread_id', $thread->id)
						->where('user_id', $recipient)
						->first();

		if ( ! $participant)
		{
			$participant = ParticipantModel::create([
				'thread_id' => $thread->id,
				'user_id' => $recipient,
			    'last_read' => $lastRead,
			]);
		}

		return $participant;
	}

	public function allFor($user, $folder_id, $withRelations = false)
	{
		$query = ThreadModel::select(['messages_threads.*', 'messages_threads.updated_at'])
					->orderBy('messages_threads.updated_at', 'desc')
					->distinct();

		$query->join('messages_participants', function($join) use ($user, $folder_id)
		{
			$join->on('messages_threads.id', '=', 'messages_participants.thread_id');
		});

		if ($folder_id !== 'all')
		{
			$query->where('messages_participants.user_id', '=', $user->id);

			$query->where(function($query) use ($user, $folder_id)
			{
				$query->where('messages_participants.folder_id', '=', $folder_id);

				if ($folder_id == 'inbox')
				{
					$query->orWhere('messages_participants.folder_id', '=', null);
				}
			});
		}

		$result = $query->get();

		if ($withRelations)
		{
			$result = $this->addThreadRelationsToResult($result);
		}

		return $result;
	}

	public function allFoldersFor($user)
	{
		return FolderModel::where('user_id', $user->id)->get();
	}

	public function findThreadById($thread_id)
	{
		return ThreadModel::find($thread_id);
	}

	public function readMessage($user, $thread_id)
	{
		if ($thread = $this->findThreadById($thread_id))
		{
			$this->markasRead($user, $thread);
		}

		return $thread;
	}

	/**
	 * @param $user
	 * @param $thread
	 */
	private function markasRead($user, $thread)
	{
		$participant = $thread->participants()->where('user_id', $user->id)->first();

		$participant->last_read = Carbon::now();

		$participant->save();
	}

	public function addFolder($user, $folder_name)
	{
		return FolderModel::create([
			'name' => $folder_name,
		    'user_id' => $user->id,
		]);
	}

	public function moveMessages($user, $folder_id, $threads_ids)
	{
		return ParticipantModel::where('user_id', $user->id)
				->whereIn('thread_id', $threads_ids)
				->update(['folder_id' => $folder_id]);
	}

	public function allFoldersCountFor($user)
	{
		$folders = [
			'system' => [
				'all' => ['id' => 'all', 'name' => 'All', 'count' => null],
				'inbox' => ['id' => 'inbox', 'name' => 'Inbox', 'count' => null],
				'sent' => ['id' => 'sent', 'name' => 'Sent', 'count' => null],
				'archive' => ['id' => 'archive', 'name' => 'Archive', 'count' => null],
			],

			'user' => [],
		];

		$query = DB::select(DB::raw(
			"select
					  messages_folders.id
					, messages_folders.name
					, (select count(messages_participants.id) as total
						from messages_participants
						where messages_participants.user_id = '{$user->id}'
						and messages_participants.folder_id = messages_folders.id)
					from messages_folders

			union

			select
				  messages_system_folders.id
				, messages_system_folders.name
				, case when messages_system_folders.id = 'all'
					then
						(select count(messages_participants.id) as total
							from messages_participants
							where messages_participants.user_id = '{$user->id}')
					else
						(select count(messages_participants.id) as total
							from messages_participants
							where messages_participants.user_id = '{$user->id}'
							and messages_participants.folder_id = messages_system_folders.id)
					end

				from messages_system_folders

				order by name"
		));

		foreach($query as $folder)
		{
			if (in_array($folder->id, array_keys($folders['system'])))
			{
				if ($folder->total)
				{
					$folders['system'][$folder->id]['count'] = $folder->total;
				}
			}
			else
			{
				$folders['user'][$folder->id]['id'] = $folder->id;
				$folders['user'][$folder->id]['count'] = $folder->total;
				$folders['user'][$folder->id]['name'] = $folder->name;
			}
		}

		return $folders;
	}

	public function getThreadByMessageId($message_id)
	{
		if ( ! $message = $this->getMessageById($message_id))
		{
			return null;
		}

		return $message->thread;
	}

	/**
	 * @param $message_id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	private function getMessageById($message_id)
	{
		return MessageModel::find($message_id);
	}

	private function addThreadRelationsToResult($query)
	{
		$result = [];

		foreach($query as $thread)
		{
			$result[] = [
				'id' => $thread->id,
				'subject' => $thread->subject,
				'owner' => $thread->owner->present()->fullName,
				'unread' => $thread->unread,
			    'avatar' => $thread->owner->present()->avatar(25),
			    'bodyFirstLine' => $thread->present()->bodyFirstLine,
				'hasAttachments' => $thread->hasAttachments,
			    'createdAt' => $thread->created_at->diffForHumans(),
				'isNew' => $thread->isNew,
				'hasNewReply' => $thread->hasNewReply,
			];
		}

		return $result;
	}

	private function findParticipantByThreadAndUser($thread, $user)
	{
		return $this->createParticipant($thread, $user);
	}

}
