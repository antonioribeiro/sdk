<?php

namespace PragmaRX\Sdk\Services\Currencies\Data\Repositories;

use PragmaRX\Sdk\Services\Currencies\Data\Entities\Currency as Model;

class Currency {

	public function getForSelect()
	{
		$currencies = [];

		foreach(Model::all() as $currency)
		{
			$currencies[$currency->id] = "{$currency->id} - {$currency->present()->name}";
		}

		return array_merge(
			[null => strtoupper(t('paragraphs.select-one-currency'))],
			$currencies
		);
	}

}
