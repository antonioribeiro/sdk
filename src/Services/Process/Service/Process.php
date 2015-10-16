<?php

namespace PragmaRX\Sdk\Services\Process;

use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{
	public static function execute($commandLine)
	{
		$process = new SymfonyProcess($commandLine);
		$process->run();

		// executes after the command finishes
		if ( ! $process->isSuccessful())
		{
			throw new \RuntimeException($process->getErrorOutput());
		}

		echo $process->getOutput();
	}
}
