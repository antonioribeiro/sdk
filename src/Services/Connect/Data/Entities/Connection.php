<?php

namespace PragmaRX\Sdk\Services\Connect\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Connection extends Model {

	protected $fillable = ['requested_id', 'requestor_id'];

	public function requestor()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User', 'requestor_id');
	}

	public function requested()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User', 'requested_id');
	}

	public function connectedTo($user)
	{
		$requestor = $this->requestor;

		if ($requestor->id == $user->id)
		{
			return $this->requested;
		}

		return $this->requestor;
	}

}
