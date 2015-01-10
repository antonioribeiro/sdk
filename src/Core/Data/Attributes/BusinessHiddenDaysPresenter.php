<?php

namespace PragmaRX\Sdk\Core\Data\Attributes;


trait BusinessHiddenDaysPresenter {

	public function businessHiddenDays()
	{
		$days = array_keys($this->business_days);

		return implode(',', array_diff([0,1,2,3,4,5,6], $days));
	}

}
