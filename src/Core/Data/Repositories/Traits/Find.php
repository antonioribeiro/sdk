<?php

namespace PragmaRX\Sdk\Core\Data\Repositories\Traits;

trait Find
{
    public function find($id)
    {
        return $this->findById($id);
    }

    public function findByName($name)
    {
        return $this->getNewModel()->where('name', $name)->first();
    }

    public function findByEmail($email)
    {
        return $this->getModel()->where('email', $email)->first();
    }

	public function findById($id)
	{
		return $this
			->call($this->getModel(), 'findOrFail', $id);
	}
}
