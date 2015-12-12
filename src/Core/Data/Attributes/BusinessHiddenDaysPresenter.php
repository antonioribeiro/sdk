<?php

namespace PragmaRX\Sdk\Core\Data\Attributes;

trait BusinessHiddenDaysPresenter {

	public function businessHiddenDays()
	{
		$days = array_keys($this->business_days);

		$allDays = [0,1,2,3,4,5,6];
		$allDaysString = implode(',', $allDays);

		$hidden = implode(',', array_diff($allDays, $days));

		// Do not, ever!, hide all days
		return $hidden == $allDaysString ? '' : $hidden;
	}

}
