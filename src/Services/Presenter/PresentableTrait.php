<?php

namespace PragmaRX\Sdk\Services\Presenter;

use PragmaRX\Sdk\Services\Presenter\Exceptions\PresenterException;

trait PresentableTrait
{
	/**
	 * Prepare a new or cached presenter instance
	 *
	 * @return mixed
	 * @throws PresenterException
	 */
	public function present()
	{
		if ( ! $this->presenter or ! class_exists($this->presenter))
		{
			throw new PresenterException('Please set the $presenter property to your presenter path.');
		}

		if ( ! $this->presenterInstance)
		{
			$this->presenterInstance = new $this->presenter($this);
		}

		return $this->presenterInstance;
	}
}
