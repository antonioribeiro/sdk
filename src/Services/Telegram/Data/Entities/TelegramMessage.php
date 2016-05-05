<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Telegram\Data\Presenters\TelegramMessage as TelegramMessagePresenter;

class TelegramMessage extends Model
{
	protected $table = 'telegram_messages';

    protected $presenter = TelegramMessagePresenter::class;

    protected $fillable = [
        'telegram_message_id',
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
        return $this->belongsTo(TelegramChat::class);
    }

    public function from()
    {
        return $this->belongsTo(TelegramUser::class, 'from_id');
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
        return $this->belongsTo(TelegramDocument::class);
    }

    public function voice()
    {
        return $this->belongsTo(TelegramVoice::class);
    }

    public function video()
    {
        return $this->belongsTo(TelegramVideo::class);
    }
}
