<?php

namespace PragmaRX\Sdk\Services\Currencies\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Currency extends Model {

	protected $table = 'glottos_currencies';

	protected $presenter = 'PragmaRX\Sdk\Services\Currencies\Data\Presenters\Currency';

}
