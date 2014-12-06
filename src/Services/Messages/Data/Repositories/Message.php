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

	public function sendMessage($user, $thread_id, $recipients, $subject, $body, $attachments)
	{
		$thread = $this->findThread($thread_id, $user, $subject, $recipients);

		$message = MessageModel::create(
			[
				'thread_id' => $thread->id,
				'sender_id' => $user->id,
				'body' => $body,
			]
		);

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

			$this->createParticipant($thread, $user->id, Carbon::now());
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
		return ParticipantModel::create([
			'thread_id' => $thread->id,
			'user_id' => $this->userRepository->findById($recipient)->id,
		    'last_read' => $lastRead,
		]);
	}

	public function allFor($user)
	{
		/// NOT USING USER?!?!?!!?!?!?

		return ThreadModel::orderBy('updated_at', 'desc')->get();
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
		$thread = $this->findThreadById($thread_id);

		$this->markasRead($user, $thread);

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

}
