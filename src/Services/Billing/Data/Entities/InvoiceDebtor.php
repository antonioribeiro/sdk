<?php

namespace PragmaRX\Sdk\Services\Billing\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class InvoiceDebtor extends Model {

	protected $fillable = [
		'invoice_id',
		'debtor_id',
	];

}
