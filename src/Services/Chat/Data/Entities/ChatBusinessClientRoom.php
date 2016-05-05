<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class ChatBusinessClientRoom extends Model
{
	protected $table = 'chat_business_client_service_rooms';

	protected $fillable = [
		'chat_business_client_service_id',
		'name',
	];

	public function service()
	{
		return $this->belongsTo(ChatBusinessClientService::class, 'chat_business_client_service_id');
	}
}
