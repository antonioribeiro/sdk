<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use App\Services\Users\Data\Entities\User;
use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
use PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatBusinessClientTalker as ChatBusinessClientTalkerPresenter;

class ChatBusinessClientTalker extends Model
{
	protected $table = 'chat_business_client_talkers';

	protected $fillable = [
		'business_client_id',
		'user_id',
		'phone_id',
	];

    protected $presenter = ChatBusinessClientTalkerPresenter::class;

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function client()
	{
		return $this->belongsTo(BusinessClient::class, 'business_client_id');
	}
}
