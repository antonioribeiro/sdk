<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatBusinessClientService extends Model
{
	protected $table = 'chat_business_client_services';

	protected $fillable = [
		'business_client_id',
		'chat_service_id',
		'description',
	];

	public function type()
	{
		return $this->belongsTo(ChatService::class, 'chat_service_id');
	}
}
