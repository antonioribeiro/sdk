<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Entities;

use Auth;
use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Messages\Data\Presenters\Thread as ThreadPresenter;

class Thread extends Model
{
	protected $table = 'messages_threads';

	protected $fillable = ['owner_id', 'subject'];

    protected $presenter = ThreadPresenter::class;
    
	public function participants()
	{
		return $this->hasMany(
			'PragmaRX\Sdk\Services\Messages\Data\Entities\Participant',
			'thread_id'
		);
	}

	public function owner()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User');
	}

	public function recipients()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User');
	}

	public function messages()
	{
		return $this
				->hasMany('PragmaRX\Sdk\Services\Messages\Data\Entities\Message')
				->with('attachments');
	}

	public function getUnreadAttribute()
	{
		return $this->isNew || $this->hasNewReply;
	}

	public function getIsNewAttribute()
	{
		if ( ! $participant = $this->currentParticipant)
		{
			return false;
		}

		return $participant->last_read === null;
	}

	public function getHasNewReplyAttribute()
	{
		if ( ! $participant = $this->currentParticipant)
		{
			return false;
		}

		return $participant->last_read < $this->updated_at;
	}

	public function getCurrentParticipantAttribute()
	{
		return $this
				->participants()
				->where('messages_participants.user_id', Auth::user()->id)
				->first();
	}

	public function getMessagesByDateAttribute()
	{
		return $this
				->messages()
				->orderBy('messages_messages.updated_at')
				->get();
	}

	public function getHasAttachmentsAttribute()
	{
		foreach ($this->messages as $message)
		{
			if ($message->attachments()->count())
			{
				return true;
			}
		}

		return false;
	}
}
