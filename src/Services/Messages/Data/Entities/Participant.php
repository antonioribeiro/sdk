<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Participant extends Model {

	protected $table = 'messages_participants';

	protected $fillable = ['thread_id', 'user_id', 'last_read'];

	protected $touches = array('thread');

	public function thread()
    {
        return $this->belongsTo('PragmaRX\Sdk\Services\Messages\Data\Entities\Thread');
    }

	public function user()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User');
	}

}
