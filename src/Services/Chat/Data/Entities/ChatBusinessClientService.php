<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;

class ChatBusinessClientService extends Model
{
	protected $table = 'chat_business_client_services';

	protected $fillable = [
		'business_client_id',
		'chat_service_id',
		'description',
        'bot_name',
        'bot_token',
        'bot_webhook_url',
	];

	public function type()
	{
		return $this->belongsTo(ChatService::class, 'chat_service_id');
	}

	public function client()
	{
		return $this->belongsTo(BusinessClient::class, 'business_client_id');
	}
}
