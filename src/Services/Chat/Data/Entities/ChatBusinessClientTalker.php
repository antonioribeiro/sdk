<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use App\Services\Users\Data\Entities\User;

class ChatBusinessClientTalker extends Model
{
	protected $table = 'chat_business_client_talkers';

	protected $fillable = [
		'business_client_id',
		'user_id',
		'phone_id',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
