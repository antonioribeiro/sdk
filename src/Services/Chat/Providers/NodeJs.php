<?php

namespace PragmaRX\Sdk\Services\Chat\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class NodeJs extends ServiceProvider
{
	public function boot(Dispatcher $events)
	{
		$this->publishes([
			__DIR__.'/../NodeJs' => app_path('Services/Chat/Server/NodeJs'),
		]);
	}
}
