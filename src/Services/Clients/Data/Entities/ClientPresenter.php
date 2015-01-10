<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Entities;

use PragmaRX\Sdk\Services\Users\Data\Presenters\User as UserPresenter;

use Carbon;

class ClientPresenter extends UserPresenter {

	public function backgroundColor()
	{
		return $this->color;
	}

	public function textColor()
	{
		return getContrastYIQ($this->color);
	}

	public function age($canReturnEmpty = true)
	{
		$date = $this->entity->getAttributes()['birthdate'];

		if ($date)
		{
			$date = Carbon::createFromFormat('Y-m-d', $date)->age;
		}

		return $date
				? $date . ' ' . p('captions.years-old', $date)
				: ($canReturnEmpty ? '' : t('captions.birthday-not-informed'));
	}

}
