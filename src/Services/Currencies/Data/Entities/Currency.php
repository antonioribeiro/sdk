<?php

namespace PragmaRX\Sdk\Services\Currencies\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Currencies\Data\Presenters\Currency as CurrencyPresenter;

class Currency extends Model
{
	protected $table = 'currencies';

    protected $presenter = CurrencyPresenter::class;
}
