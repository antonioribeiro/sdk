<?php

namespace PragmaRX\Sdk\Services\Process\Service;

use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{
	public static function start($commandLine)
	{
		$process = new SymfonyProcess($commandLine);
		$process->start();
	}
}
