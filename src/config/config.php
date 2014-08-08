<?php
/**
 * Part of the SDK package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    SDK
 * @author     Antonio Carlos Ribeiro @ PragmaRX
 * @license    BSD License (3-clause)
 * @copyright  (c) 2013, PragmaRX
 * @link       http://pragmarx.com
 */

return array(

	/**
	 * Enable it?
	 */
	'enabled' => false,

	/**
	 * Robots should be tracked?
	 */
	'do_not_track_robots' => true,

	/**
	 * Which environments are not trackable?
	 */
	'do_not_track_environments' => array(
		// defaults to none
	),

	/**
	 * Which routes names are not trackable?
	 */
	'do_not_track_routes' => array(
		'sdk.stats.*',
	),

	/**
	 * The Do Not Track Ips is used to disable SDK for some IP addresses:
	 *
	 *     '127.0.0.1', '192.168.1.1'
	 *
	 * You can set ranges of IPs
	 *     '192.168.0.1-192.168.0.100'
	 *
	 * And use net masks
	 *     '10.0.0.0/32'
	 *     '172.17.0.0/255.255.0.0'
	 */
	'do_not_track_ips' => array(
		'127.0.0.0/24' /// range 127.0.0.1 - 127.0.0.255
	),

	/**
	 * Log every single access?
	 *
	 * The log table can become huge if your site is popular, but...
	 *
	 * Log table is also responsible for storing information on:
	 *
	 *    - Routes and controller actions accessed
	 *    - HTTP method used (GET, POST...)
	 *    - Error log
	 *    - URL queries (including values)
	 */
	'log_enabled' => false,

	/**
	 * Log SQL queries?
	 *
	 * Log must be enabled for this option to work.
	 */
	'log_sql_queries' => false,

	/**
	 * If you prefer to store SDK data on a different database or connection,
	 * you can set it here.
	 *
	 * To avoid SQL queries log recursion, create a different connection for SDK,
	 * point it to the same database (or not) and forbid logging of this connection in
	 * do_not_log_sql_queries_connections.
	 */
	'connection' => null,

	/**
	 * Forbid logging of SQL queries for some connections.
	 *
	 * To avoid recursion, you better ignore SDK connection here.
	 */
	'do_not_log_sql_queries_connections' => array(
		// defaults to none
	),

	/**
	 * Also log SQL query bindings?
	 *
	 * Log must be enabled for this option to work.
	 */
	'log_sql_queries_bindings' => false,

	/**
	 * Log events?
	 */
	'log_events' => false,

	/**
	 * Which events do you want to log exactly?
	 */
	'log_only_events' => array(
		// defaults to logging all events
	),

	/**
	 * What are the names of the id columns on your system?
	 *
	 * 'id' is the most common, but if you have one or more different,
	 * please add them here in your preference order.
	 */
	'id_columns_names' => array(
		'id'
	),
	/**
	 * Do not log events for the following patterns.
	 * Strings accepts wildcards:
	 *
	 *    eloquent.*
	 *
	 */
	'do_not_log_events' => array(
		'illuminate.log',
		'eloquent.*',
		'router.*',
		'composing: *',
		'creating: *',
	),

	/**
	 * Do you wish to log Geo IP data?
	 *
	 * You will need to install the geoip package
	 *
	 *     composer require "geoip/geoip":"~1.14"
	 *
	 * And remove the PHP module
	 *
	 *     sudo apt-get purge php5-geoip
	 *
	 */
	'log_geoip' => false,

	/**
	 * Do you wish to log the user agent?
	 */
	'log_user_agents' => true,

	/**
	 * Do you wish to log your users?
	 */
	'log_users' => true,

	/**
	 * Do you wish to log devices?
	 */
	'log_devices' => true,

	/**
	 * Do you wish to log HTTP referers?
	 */
	'log_referers' => true,

	/**
	 * Do you wish to log url paths?
	 */
	'log_paths' => true,

	/**
	 * Do you wish to log url queries and query arguments?
	 */
	'log_queries' => true,

	/**
	 * Do you wish to log routes and route parameters?
	 */
	'log_routes' => true,

	/**
	 * Log errors and exceptions?
	 */
	'log_exceptions' => true,

	/**
	 * A cookie may be created on your visitor device, so you can have information
	 * on everything made using that device on your site.	 *
	 */
	'store_cookie_sdk' => true,

	/**
	 * If you are storing cookies, you better change it to a name you of your own.
	 */
	'sdk_cookie_name' => 'please_change_this_cookie_name',

	/**
	 * Internal sdk session name.
	 */
    'sdk_session_name' => 'sdk_session',

	/**
	 * ** IMPORTANT **
	 *   Change the user model to your own.
	 */
	'user_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\User',

	/**
	 * You can use your own model for every single table SDK has.
	 */

    'session_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Session',

    'log_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Log',

	'path_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Path',

	'query_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Query',

	'query_argument_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\QueryArgument',

	'agent_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Agent',

    'device_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Device',

    'cookie_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Cookie',

	'domain_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Domain',

	'referer_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Referer',

	'route_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Route',

	'route_path_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\RoutePath',

	'route_path_parameter_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\RoutePathParameter',

	'error_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Error',

	'geoip_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\GeoIp',

	'sql_query_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\SqlQuery',

	'sql_query_binding_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\SqlQueryBinding',

	'sql_query_binding_parameter_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\SqlQueryBindingParameter',

	'sql_query_log_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\SqlQueryLog',

	'connection_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Connection',

	'event_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\Event',

	'event_log_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\EventLog',

	'system_class_model' => 'PragmaRX\SDK\Vendor\Laravel\Models\SystemClass',

	/**
	 * Laravel internal variables on user authentication and login.
	 */
	'authentication_ioc_binding' => 'auth', // defaults to 'auth' in Illuminate\Support\Facades\Auth

    'authenticated_check_method' => 'check', // to Auth::check()

    'authenticated_user_method' => 'user', // to Auth::user()

    'authenticated_user_id_column' => 'id', // to Auth::user()->id

    'authenticated_user_username_column' => 'email', // to Auth::user()->email

	/**
	 * Laravel Alias, create one? Which name?
	 */
	'create_sdk_alias' => true,

	'sdk_alias' => 'SDK',

	/**
	 * Enable the Stats Panel?
	 */
	'stats_panel_enabled' => false,

	/**
	 * Stats Panel routes before filter
	 *
	 * You better drop an 'auth' filter here.
	 */
	'stats_routes_before_filter' => '',

	/**
     * Stats Panel template path
     */
    'stats_template_path' => '/templates/sb-admin-2',

    /**
     * Stats Panel base uri.
     *
     * If your site url is http://wwww.mysite.com, then your stats page will be:
     *
     *    http://wwww.mysite.com/stats
     *
     */
    'stats_base_uri' => 'stats',

    /**
     * Stats Panel layout view
     */
    'stats_layout' => 'pragmarx/sdk::layout',

    /**
     * Stats Panel controllers namespace
     */
    'stats_controllers_namespace' => 'PragmaRX\SDK\Vendor\Laravel\Controllers',
);
