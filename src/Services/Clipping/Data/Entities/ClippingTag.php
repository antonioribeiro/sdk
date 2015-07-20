<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Tags\Data\Entities\Tag;

class ClippingTag extends Model
{
	protected $table = 'clipping_tags';

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
