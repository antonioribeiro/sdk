<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Presenters\FacebookMessengerMessage as FacebookMessengerMessagePresenter;

class FacebookMessengerMessage extends Model
{
	protected $table = 'facebook_messenger_messages';

    protected $presenter = FacebookMessengerMessagePresenter::class;

    protected $fillable = [
        'facebook_messenger_message_id',
        'chat_id',
        'from_id',
        'date',
        'timestamp',
        'forward_from_id',
        'forward_date',
        'reply_to_message_id',
        'text',
        'audio_id',
        'document_id',
        'photo',
        'entities',
        'sticker_id',
        'video_id',
        'voice_id',
        'venue_id',
        'caption',
        'contact_id',
        'location_id',
        'new_chat_participant_id',
        'left_chat_participant_id',
        'new_chat_title',
        'new_chat_photo',
        'delete_chat_photo',
        'group_chat_created',
        'supergroup_chat_created',
        'channel_chat_created',
        'migrate_to_chat_id',
        'migrate_from_chat_id',
    ];

    public function chat()
    {
        return $this->belongsTo(FacebookMessengerChat::class);
    }

    public function from()
    {
        return $this->belongsTo(FacebookMessengerUser::class, 'from_id');
    }

    public function user()
    {
        return $this->from();
    }

    public function getIpAddressAttribute()
    {
        return '0.0.0.0';
    }

    public function document()
    {
        return $this->belongsTo(FacebookMessengerDocument::class);
    }

    public function voice()
    {
        return $this->belongsTo(FacebookMessengerVoice::class);
    }

    public function video()
    {
        return $this->belongsTo(FacebookMessengerVideo::class);
    }
}
