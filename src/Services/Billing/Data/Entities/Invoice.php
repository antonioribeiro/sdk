<?php

namespace PragmaRX\Sdk\Services\Billing\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Billing\Data\Presenters\Invoice as InvoicePresenter;

class Invoice extends Model
{
	protected $fillable = [
		'items_entity_id',
		'creditor_entity_id',
		'debtor_entity_id',
		'currency_id',
		'total',
		'due_date',
		'fully_payed_at',
		'notes',
		'last_reminder',
	];

	protected $presenter = InvoicePresenter::class;
}
