<?php

namespace PragmaRX\Sdk\Services\TwoFactor\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TwoFactorType extends Model {

	protected $fillable = ['code', 'name'];

	protected $table = 'two_factor_types';

	protected $presenter = 'PragmaRX\Sdk\Services\Statuses\Data\Entities\StatusPresenter';

}
