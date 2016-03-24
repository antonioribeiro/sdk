<?php

namespace PragmaRX\Sdk\Services\ContactInformation\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ContactInformation extends Model
{
	protected $table = 'contact_information';

	protected $fillable = ['user_id', 'kind_id', 'info'];

	public function kind()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Kinds\Data\Entities\Kind');
	}
}
