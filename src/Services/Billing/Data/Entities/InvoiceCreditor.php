<?php

namespace PragmaRX\Sdk\Services\Billing\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class InvoiceCreditor extends Model {

	protected $fillable = [
		'invoice_id',
		'creditor_id',
	];

}
