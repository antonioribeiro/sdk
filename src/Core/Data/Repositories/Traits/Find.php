<?php

namespace PragmaRX\Sdk\Core\Data\Repositories\Traits;

trait Find
{
	public function findById($id)
	{
		return $this
			->call($this->getModel(), 'findOrFail', $id);
	}
}
