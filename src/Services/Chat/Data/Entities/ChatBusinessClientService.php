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
        'app_id',
        'app_secret',
	];

    protected $appends = ['bot_token_ellipse'];

    public function type()
	{
		return $this->belongsTo(ChatService::class, 'chat_service_id');
	}

	public function client()
	{
		return $this->belongsTo(BusinessClient::class, 'business_client_id');
	}

    public function getBotTokenEllipseAttribute()
    {
        if (strlen($this->bot_token) > 60)
        {
            return substr($this->bot_token, 0, 60). '...';
        }

        return $this->bot_token;
    }
}
