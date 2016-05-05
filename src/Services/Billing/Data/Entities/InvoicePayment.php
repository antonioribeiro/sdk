<?php

namespace PragmaRX\Sdk\Services\Billing\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class InvoicePayment extends Model {

	protected $fillable = [
		'invoice_id',
		'amount',
		'payer_id',
	];

}
