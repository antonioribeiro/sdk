<?php

namespace PragmaRX\Sdk\Services\Kinds\Data\Repositories;

use PragmaRX\Sdk\Services\Kinds\Data\Entities\Kind;

class KindRepository {

	public function allForSelect()
	{
		$kinds = Kind::lists('name', 'id');

		foreach ($kinds as $key => $kind)
		{
			$kinds[$key] = t($kinds[$key]);
		}

		return [0 => t('captions.contact-type')] + $kinds;
	}

}
