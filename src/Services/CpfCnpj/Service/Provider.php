<?php

namespace PragmaRX\Sdk\Services\CpfCnpj\Service;

use PragmaRX\Support\CpfCnpj\Cpf;
use PragmaRX\Support\CpfCnpj\Cnpj;
use PragmaRX\Support\ServiceProvider;

class Provider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Validator::extend('cpf', function($attribute, $value, $parameters, $validator) {
            return CPF::validar($value);
        });
    }

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
        Validator::extend('cpf', function($attribute, $value, $parameters, $validator) {
            return Cpf::validar($value);
        });

        Validator::extend('cnpj', function($attribute, $value, $parameters, $validator) {
            return Cnpj::validar($value);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['pragmarx.cpfcnpj'];
	}

	/**
	 * Get the current package directory.
	 *
	 * @return string
	 */
	public function getPackageDir()
	{
		return __DIR__;
	}
}
