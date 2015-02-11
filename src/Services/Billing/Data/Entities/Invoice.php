<?php

namespace PragmaRX\Sdk\Services\Billing\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Group extends Model {

	protected $fillable = ['name'];

	protected $presenter = 'PragmaRX\Sdk\Services\Billing\Data\Entities\InvoicePresenter';

}
