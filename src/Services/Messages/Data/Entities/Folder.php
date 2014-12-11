<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Folder extends Model {

	protected $table = 'messages_folders';

	protected $fillable = ['name', 'user_id'];

	public function folder()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Messages\Data\Entities\Folder');
	}

}
