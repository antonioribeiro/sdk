<?php

namespace PragmaRX\Sdk\Services\Bus\Providers;

use PragmaRX\Sdk\Services\Bus\Service\Dispatcher;
use PragmaRX\Support\ServiceProvider;

class Bus extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    private function checkLaravelConflict() {
        if (array_search(\AltThree\Bus\BusServiceProvider::class, config('app.providers'))) {
            echo 'If you want to use ' . __CLASS__ . ',<br>';
            echo 'please disable Laravel BusServiceProvider on your config';
            die;
        }
    }

    public function getPackageDir() {
        return __DIR__;
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [
            'AltThree\Bus\Dispatcher',
            'Illuminate\Contracts\Bus\Dispatcher',
            'Illuminate\Contracts\Bus\QueueingDispatcher',
        ];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->checkLaravelConflict();

        $this->app->singleton('AltThree\Bus\Dispatcher', function ($app) {
            return new Dispatcher(
                $app,
                function () use ($app)
                {
                    return $app['Illuminate\Contracts\Queue\Queue'];
                }
            );
        });

        $this->app->alias(
            'AltThree\Bus\Dispatcher', 'Illuminate\Contracts\Bus\Dispatcher'
        );

        $this->app->alias(
            'AltThree\Bus\Dispatcher', 'Illuminate\Contracts\Bus\QueueingDispatcher'
        );
    }
}
