<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Attachment extends Model {

	protected $table = 'messages_attachments';

	protected $fillable = ['message_id', 'user_file_id'];

}
