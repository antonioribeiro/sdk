<?php

namespace PragmaRX\Sdk\Services\Connect\Data\Repositories;

class Connection {

	public function usersConnectedTo($user)
	{
		$users = [];

		foreach($user->connections as $connection)
		{
			$users[] = $connection->connectedTo($user);
		}

		return $users;
	}

}
