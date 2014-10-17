<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Client extends Model {

	protected $presenter = 'PragmaRX\Sdk\Services\Clients\Data\Entities\ClientPresenter';

	protected $fillable = [
		'provider_id',
		'first_name',
		'last_name'
	];

	public function provider()
	{
		return $this
				->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User', 'provider_id');
	}

}
