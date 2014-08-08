<?php namespace PragmaRX\SDK\Vendor\Laravel;

use PragmaRX\SDK\Data\Repositories\Connection;
use PragmaRX\SDK\Data\Repositories\Event;
use PragmaRX\SDK\Data\Repositories\EventLog;
use PragmaRX\SDK\Data\Repositories\SqlQueryBindingParameter;
use PragmaRX\SDK\Data\Repositories\SystemClass;
use PragmaRX\SDK\Eventing\EventStorage;
use PragmaRX\SDK\SDK;

use PragmaRX\SDK\Services\Authentication;

use PragmaRX\SDK\Support\Config;
use PragmaRX\SDK\Support\MobileDetect;
use PragmaRX\SDK\Support\UserAgentParser;

use PragmaRX\SDK\Support\Database\Migrator as Migrator;

use PragmaRX\SDK\Data\Repositories\Session;
use PragmaRX\SDK\Data\Repositories\Log;
use PragmaRX\SDK\Data\Repositories\Path;
use PragmaRX\SDK\Data\Repositories\Query;
use PragmaRX\SDK\Data\Repositories\QueryArgument;
use PragmaRX\SDK\Data\Repositories\Agent;
use PragmaRX\SDK\Data\Repositories\Device;
use PragmaRX\SDK\Data\Repositories\Cookie;
use PragmaRX\SDK\Data\Repositories\Domain;
use PragmaRX\SDK\Data\Repositories\Referer;
use PragmaRX\SDK\Data\Repositories\Route;
use PragmaRX\SDK\Data\Repositories\RoutePath;
use PragmaRX\SDK\Data\Repositories\RoutePathParameter;
use PragmaRX\SDK\Data\Repositories\Error;
use PragmaRX\SDK\Data\Repositories\GeoIp as GeoIpRepository;
use PragmaRX\SDK\Data\Repositories\SqlQuery;
use PragmaRX\SDK\Data\Repositories\SqlQueryLog;
use PragmaRX\SDK\Data\Repositories\SqlQueryBinding;

use PragmaRX\SDK\Data\RepositoryManager;

use PragmaRX\SDK\Vendor\Laravel\Artisan\Tables as TablesCommand;
use PragmaRX\SDK\Vendor\Laravel\Artisan\UpdateParser as UpdateParserCommand;

use PragmaRX\Support\GeoIp;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Foundation\AliasLoader as IlluminateAliasLoader;

class ServiceProvider extends IlluminateServiceProvider {

    const PACKAGE_NAMESPACE = 'pragmarx/sdk';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package(self::PACKAGE_NAMESPACE, self::PACKAGE_NAMESPACE, __DIR__.'/../..');

        if( $this->app['config']->get(self::PACKAGE_NAMESPACE.'::create_sdk_alias') )
        {
            IlluminateAliasLoader::getInstance()->alias(
                                                            $this->getConfig('sdk_alias'),
                                                            'PragmaRX\SDK\Vendor\Laravel\Facade'
                                                        );
        }

	    $this->loadRoutes();

	    $this->registerErrorHandler();

        $this->wakeUp();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	    $this->registerConfig();

        $this->registerAuthentication();

        $this->registerMigrator();

        $this->registerRepositories();

        $this->registerSDK();

	    $this->registerTablesCommand();

        $this->registerUpdateParserCommand();

	    $this->registerExecutionCallBack();

	    $this->registerSqlQueryLogWatcher();

	    $this->registerGlobalEventLogger();

	    $this->commands('sdk.tables.command');

        $this->commands('sdk.updateparser.command');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('sdk');
    }

    /**
     * Takes all the components of SDK and glues them
     * together to create SDK.
     *
     * @return void
     */
    private function registerSDK()
    {
        $this->app['sdk'] = $this->app->share(function($app)
        {
            $app['sdk.loaded'] = true;

            return new SDK(
                                    $app['sdk.config'],
                                    $app['sdk.repositories'],
                                    $app['request'],
                                    $app['router'],
                                    $app['sdk.migrator'],
                                    $app['log'],
                                    $app
                                );
        });
    }

    public function registerRepositories()
    {
        $this->app['sdk.repositories'] = $this->app->share(function($app)
        {
            try
            {
                $uaParser = new UserAgentParser($app->make('path.base'));
            }
            catch (\Exception $exception)
            {
                $uaParser = null;
            }

            $sessionModel = $this->instantiateModel('session_model');

            $logModel = $this->instantiateModel('log_model');

            $agentModel = $this->instantiateModel('agent_model');

            $deviceModel = $this->instantiateModel('device_model');

            $cookieModel = $this->instantiateModel('cookie_model');

	        $pathModel = $this->instantiateModel('path_model');

			$queryModel = $this->instantiateModel('query_model');

			$queryArgumentModel = $this->instantiateModel('query_argument_model');

	        $domainModel = $this->instantiateModel('domain_model');

	        $refererModel = $this->instantiateModel('referer_model');

	        $routeModel = $this->instantiateModel('route_model');

	        $routePathModel = $this->instantiateModel('route_path_model');

	        $routePathParameterModel = $this->instantiateModel('route_path_parameter_model');

	        $errorModel = $this->instantiateModel('error_model');

	        $geoipModel = $this->instantiateModel('geoip_model');

	        $sqlQueryModel = $this->instantiateModel('sql_query_model');

            $sqlQueryBindingModel = $this->instantiateModel('sql_query_binding_model');

	        $sqlQueryBindingParameterModel = $this->instantiateModel('sql_query_binding_parameter_model');

            $sqlQueryLogModel = $this->instantiateModel('sql_query_log_model');

	        $connectionModel = $this->instantiateModel('connection_model');

	        $eventModel = $this->instantiateModel('event_model');

	        $eventLogModel = $this->instantiateModel('event_log_model');

	        $systemClassModel = $this->instantiateModel('system_class_model');

	        $logRepository = new Log($logModel);

	        $connectionRepository = new Connection($connectionModel);

	        $sqlQueryBindingRepository = new SqlQueryBinding($sqlQueryBindingModel);

	        $sqlQueryBindingParameterRepository = new SqlQueryBindingParameter($sqlQueryBindingParameterModel);

	        $sqlQueryLogRepository = new SqlQueryLog($sqlQueryLogModel);

	        $sqlQueryRepository = new SqlQuery(
		        $sqlQueryModel,
		        $sqlQueryLogRepository,
		        $sqlQueryBindingRepository,
		        $sqlQueryBindingParameterRepository,
		        $connectionRepository,
		        $logRepository,
		        $app['sdk.config']
	        );

			$eventLogRepository = new EventLog($eventLogModel);

			$systemClassRepository = new SystemClass($systemClassModel);

	        $eventRepository = new Event(
		        $eventModel,
		        $app['sdk.events'],
		        $eventLogRepository,
		        $systemClassRepository,
		        $logRepository,
		        $app['sdk.config']
	        );

	        $routeRepository = new Route(
		        $routeModel,
		        $app['sdk.config']
	        );

	        return new RepositoryManager(
	            new GeoIp(),

	            new MobileDetect,

	            $uaParser,

	            $app['sdk.authentication'],

	            $app['session.store'],

	            $app['sdk.config'],

                new Session($sessionModel,
                            $app['sdk.config'],
                            $app['session.store']),

                $logRepository,

                new Path($pathModel),

                new Query($queryModel),

                new QueryArgument($queryArgumentModel),

                new Agent($agentModel),

                new Device($deviceModel),

                new Cookie($cookieModel,
                            $app['sdk.config'],
                            $app['request'],
                            $app['cookie']),

                new Domain($domainModel),

                new Referer($refererModel),

                $routeRepository,

                new RoutePath($routePathModel),

                new RoutePathParameter($routePathParameterModel),

                new Error($errorModel),

                new GeoIpRepository($geoipModel),

				$sqlQueryRepository,

                $sqlQueryBindingRepository,

                $sqlQueryBindingParameterRepository,

                $sqlQueryLogRepository,

	            $connectionRepository,

	            $eventRepository,

	            $eventLogRepository,

	            $systemClassRepository
            );
        });
    }

    public function registerAuthentication()
    {
        $this->app['sdk.authentication'] = $this->app->share(function($app)
        {
            return new Authentication($app['sdk.config'], $app);
        });
    }

    public function registerConfig()
    {
        $this->app['sdk.config'] = $this->app->share(function($app)
        {
            return new Config($app['config'], self::PACKAGE_NAMESPACE);
        });
    }

    public function registerMigrator()
    {
        $this->app['sdk.migrator'] = $this->app->share(function($app)
        {
            $connection = $this->getConfig('connection');

            return new Migrator($app['db'], $connection);
        });
    }

    private function wakeUp()
    {
        $this->app['sdk']->boot();
    }

    private function getConfig($key)
    {
        return $this->app['config']->get(self::PACKAGE_NAMESPACE.'::'.$key);
    }

	private function registerTablesCommand()
	{
		$this->app['sdk.tables.command'] = $this->app->share(function($app)
		{
			return new TablesCommand();
		});
	}

    private function registerUpdateParserCommand()
    {
        $this->app['sdk.updateparser.command'] = $this->app->share(function($app)
        {
            return new UpdateParserCommand(
	            $app['sdk.config']
            );
        });
    }

	private function registerExecutionCallBack()
	{
		$me = $this;

		$this->app['events']->listen('router.matched', function() use ($me)
		{
			$me->app['sdk']->routerMatched();
		});
	}

	private function registerErrorHandler()
	{
		if ($this->getConfig('log_exceptions'))
		{
			$me = $this;

			$this->app->error(function(\Exception $exception, $code) use ($me)
			{
				$me->app['sdk']->handleException($exception, $code);
			});
		}
	}

	private function instantiateModel($modelName)
	{
		$model = $this->getConfig($modelName);

		if ( ! $model)
		{
			$message = "SDK: Model not found for '$modelName'.";

			$this->app['log']->error($message);

			throw new \Exception($message);
		}

        $model = new $model;

        $model->config = $this->app['sdk.config'];

        if ($connection = $this->getConfig('connection'))
        {
            $model->setConnection($connection);
        }

		return $model;
	}

	private function registerSqlQueryLogWatcher()
	{
		$me = $this;

		$this->app['events']->listen('illuminate.query', function($query,
		                                                          $bindings,
		                                                          $time,
		                                                          $name) use ($me)
		{
			$me->app['sdk']->logSqlQuery(
				$query, $bindings, $time, $name
			);
		});
	}

	private function registerGlobalEventLogger()
	{
		$me = $this;

		$this->app['sdk.events'] = $this->app->share(function($app)
		{
			return new EventStorage();
		});

		$this->app['events']->listen('*', function($object = null) use ($me)
		{
			if ($me->app['sdk.events']->isOff())
			{
				return;
			}

			// To avoid infinite recursion, event tracking while logging events
			// must be turned off
			$me->app['sdk.events']->turnOff();

			// Log events even before application is ready
			$me->app['sdk.events']->logEvent(
				$me->app['events']->firing(),
				$object
			);

			// Can only send events to database after application is ready
			if (isset($me->app['sdk.loaded']))
			{
				$me->app['sdk']->logEvents();
			}

			// Turn the event tracking to on again
			$me->app['sdk.events']->turnOn();
		});

	}

	private function loadRoutes()
	{
		if ($this->app['config']->get(self::PACKAGE_NAMESPACE.'::stats_panel_enabled'))
		{
			include __DIR__.'/../../Vendor/Laravel/App/routes.php';
		}
	}

}
