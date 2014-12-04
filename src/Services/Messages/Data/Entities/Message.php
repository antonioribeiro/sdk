<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Message extends Model {

	protected $table = 'messages_messages';

	protected $presenter = 'PragmaRX\Sdk\Services\Messages\Data\Entities\MessagePresenter';

	protected $fillable = [
		'thread_id',
	    'sender_id',
	    'body',
	];

	public function attachments()
	{
		return $this->belongsToMany(
			'PragmaRX\Sdk\Services\Messages\Data\Entities\Attachment',
			'messages_attachments',
			'message_id',
			'user_file_id'
		);
	}

}
