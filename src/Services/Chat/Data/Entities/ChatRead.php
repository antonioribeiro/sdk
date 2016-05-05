<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class ChatRead extends Model
{
	protected $table = 'chat_reads';

	protected $fillable = [
		'chat_business_client_talker_id',
		'chat_id',
		'last_read_message_serial',
	];

	public function chat()
	{
		return $this->belongsTo(Chat::class, 'chat_id');
	}

	public function talker()
	{
		return $this->belongsTo(ChatBusinessClientTalker::class, 'chat_business_client_talker_id');
	}
}
