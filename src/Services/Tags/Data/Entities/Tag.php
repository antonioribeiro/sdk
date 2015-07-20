<?php

namespace PragmaRX\Sdk\Services\Tags\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Tag extends Model {

	protected $table = 'tags';

	protected $presenter = 'PragmaRX\Sdk\Services\Tags\Data\Entities\ClientPresenter';

}
