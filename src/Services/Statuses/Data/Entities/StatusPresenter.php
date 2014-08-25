<?php

namespace PragmaRX\Sdk\Services\Statuses\Data\Entities;

use PragmaRX\Sdk\Core\Presenter;

class StatusPresenter extends Presenter {

	/**
	 * Present the time since published in a human format
	 *
	 * @return string
	 */
	public function timeSincePublished()
	{
		return $this->created_at->diffForHumans();
	}

	public function timestamp()
	{
		return
			$this->created_at->toTimeString() .
			' - ' .
			$this->created_at->toFormattedDateString();
	}
}
