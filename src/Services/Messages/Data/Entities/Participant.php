<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class Participant extends Model {

	protected $table = 'messages_participants';

	protected $fillable = ['thread_id', 'user_id', 'last_read'];

	protected $touches = array('thread');

	protected $systemFolders = ['all','inbox','sent','archive'];

	public function thread()
    {
        return $this->belongsTo('PragmaRX\Sdk\Services\Messages\Data\Entities\Thread');
    }

	public function user()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User');
	}

	public function folder()
	{
		if (in_array($this->folder_id, $this->systemFolders))
		{
			return $this->belongsTo('PragmaRX\Sdk\Services\Messages\Data\Entities\SystemFolder');
		}

		return $this->belongsTo('PragmaRX\Sdk\Services\Messages\Data\Entities\Folder');
	}

}
