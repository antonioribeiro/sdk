<?php

namespace PragmaRX\Sdk\Services\Files\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class File extends Presenter {

	public function sizeForHumans()
	{
		return human_readable_size($this->size);
	}

}
