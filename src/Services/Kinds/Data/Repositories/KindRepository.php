<?php

namespace PragmaRX\Sdk\Services\Kinds\Data\Repositories;

use PragmaRX\Sdk\Services\Kinds\Data\Entities\Kind;
use PragmaRX\Sdk\Core\Data\Repositories\Repository;

class KindRepository extends Repository
{
    protected $model = Kind::class;

	public function allForSelect()
	{
		$kinds = Kind::lists('name', 'id')->toArray();

		foreach ($kinds as $key => $kind)
		{
			$kinds[$key] = t($kinds[$key]);
		}

		return [0 => t('captions.contact-type')] + $kinds;
	}
}
