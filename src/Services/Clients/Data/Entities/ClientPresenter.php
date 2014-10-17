<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Entities;

use PragmaRX\Sdk\Core\Presenter;

class ClientPresenter extends Presenter {

	public function fullName()
	{
		return $this->first_name .
					($this->last_name ? ' ' : '') .
					$this->last_name;
	}

}
