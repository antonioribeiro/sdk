<?php

namespace PragmaRX\Sdk\Services\Currencies\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class Currency extends Presenter {

	public function name()
	{
		return t('currencies.' . $this->entity->name);
	}

}
