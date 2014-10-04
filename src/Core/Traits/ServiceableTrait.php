<?php

namespace PragmaRX\Sdk\Core\Traits;

use File;

trait ServiceableTrait {

	private function getApplicationServices($path = null)
	{
		$path = $path ?: $this->getConfig('application_services_path');

		if (file_exists($path))
		{
			$services = [];

			foreach (File::directories($path) as $dir)
			{
				$services[] = basename($dir);
			}

			return $services;
		}

		return [];
	}

}
