<?php

namespace PragmaRX\Sdk\Services\Messages\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class Thread extends Presenter {

	public function bodyFirstLine()
	{
		return 'this is the first line';
	}

	public function currentFolder()
	{
		return 'Inbox';
	}

}
