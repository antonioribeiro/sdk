<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;

class ChatScript extends Model
{
	protected $table = 'chat_scripts';

	protected $fillable = [
		'name',
		'business_client_id',
		'chat_service_id',
		'script',
		'chat_script_type_id',
	];

	protected $presenter = 'PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatPresenter';

	public function client()
	{
		return $this->belongsTo(BusinessClient::class, 'business_client_id');
	}

	public function service()
	{
		return $this->belongsTo(ChatService::class, 'chat_service_id');
	}

	public function type()
	{
		return $this->belongsTo(ChatScriptType::class, 'chat_script_type_id');
	}
}
