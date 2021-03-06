<?php

namespace PragmaRX\Sdk\Services\Chat\Console\Commands;

use Illuminate\Console\Command;
use PragmaRX\Sdk\Services\Process\Service\Process;

class ChatServe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Boot chat server';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    $command = 'node ' . app_path('Services/Chat/Server/NodeJs/socket.js');

//		Process::start($command);
//	    $this->info('Server successfuly started');
	    $this->info('Please, manually execute: '.$command);
    }
}
