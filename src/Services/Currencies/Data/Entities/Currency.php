<?php

namespace PragmaRX\Sdk\Services\Currencies\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Currencies\Data\Presenters\Currency as CurrencyPresenter;

class Currency extends Model
{
	protected $table = 'glottos_currencies';

    protected $presenter = CurrencyPresenter::class;
}
