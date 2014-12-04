<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Thread extends Model {

	protected $table = 'messages_threads';

	protected $fillable = ['owner_id', 'subject'];

	public function participants()
	{
		return $this->belongsToMany(
			'PragmaRX\Sdk\Services\Messages\Data\Entities\Participant',
			'messages_participants',
			'thread_id',
			'user_id'
		);
	}

	public function owner()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User');
	}

}
