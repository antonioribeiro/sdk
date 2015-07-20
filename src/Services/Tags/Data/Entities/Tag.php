<?php

namespace PragmaRX\Sdk\Services\Tags\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingTag;

class Tag extends Model {

	protected $table = 'tags';

	protected $presenter = 'PragmaRX\Sdk\Services\Tags\Data\Entities\ClientPresenter';

	public static function findOrCreateTag($tag)
	{
		if ( ! $tag = clear_tag($tag))
		{
			return null;
		}

		return Tag::firstOrCreate(['name' => $tag]);
	}

	public function clipping()
	{
		return $this->belongsToMany(ClippingTag::class);
	}
}
