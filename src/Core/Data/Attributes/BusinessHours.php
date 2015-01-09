<?php

namespace PragmaRX\Sdk\Core\Data\Attributes;


trait BusinessHours {

	public function setBusinessDaysAttribute($value)
	{
		$this->attributes['business_days'] = implode('', array_keys($value));
	}

	public function getBusinessDaysAttribute($value)
	{
		$result = [];

		foreach (str_split($value) as $char)
		{
			$result[$char] = 1;
		}

		return $result;
	}

}
