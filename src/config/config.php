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

return [

	'models' => [
		'user' => 'PragmaRX\SDK\Users\User',
	],

	'services' => [
		'Registration',
		'Login',
		'Messaging',
	    'Accounts',
	],

	'disabled.packages' => [

	],

	'packages' => [

		[
			'name' => 'pragmarx/auth',
			'enabled' => true,
		    'serviceProvider' => 'PragmaRX\SDK\Auth\ServiceProvider',
			'facades' => [
				'Authentication' => 'PragmaRX\SDK\Auth\Facade',
			]
		],

		[
			'name' => 'pragmarx/tracker',
			'enabled' => true,
		    'serviceProvider' => 'PragmaRX\Tracker\Vendor\Laravel\ServiceProvider',
		],

		[
			'name' => 'pragmarx/firewall',
			'enabled' => true,
			'serviceProvider' => 'PragmaRX\Firewall\Vendor\Laravel\ServiceProvider',
		],

		[
			'name' => 'pragmarx/sqli',
			'enabled' => true,
			'serviceProvider' => 'PragmaRX\SqlI\Vendor\Laravel\ServiceProvider',
		],

		[
			'name' => 'pragmarx/glottos',
			'enabled' => true,
			'serviceProvider' => 'PragmaRX\Glottos\Vendor\Laravel\ServiceProvider',
		],

		[
			'name' => 'way/generators',
			'enabled' => true,
			'serviceProvider' => 'Way\Generators\GeneratorsServiceProvider',
		],

		[
			'name' => 'laracasts/commander',
			'enabled' => true,
			'serviceProvider' => 'Laracasts\Commander\CommanderServiceProvider',
		],

		[
			'name' => 'laracasts/validation',
			'enabled' => true,
			'serviceProvider' => 'Laracasts\Validation\ValidationServiceProvider',
		],

		[
			'name' => 'laracasts/utilities',
			'enabled' => true,
			'serviceProvider' => 'Laracasts\Utilities\UtilitiesServiceProvider',
		],

		[
			'name' => 'laracasts/flash',
			'enabled' => true,
			'serviceProvider' => 'Laracasts\Flash\FlashServiceProvider',
			'facades' => [
				'Flash' => 'Laracasts\Flash\Flash',
			]
		],

		[
			'name' => 'cartalyst/sentinel',
			'enabled' => true,
			'serviceProvider' => 'Cartalyst\Sentinel\Laravel\SentinelServiceProvider',
		    'facades' => [
				'Activation' => 'Cartalyst\Sentinel\Laravel\Facades\Activation',
				'Reminder'   => 'Cartalyst\Sentinel\Laravel\Facades\Reminder',
				'Sentinel'   => 'Cartalyst\Sentinel\Laravel\Facades\Sentinel',
		    ]
		],

		[
			'name' => 'jenssegers/date',
			'enabled' => true,
			'serviceProvider' => 'Jenssegers\Date\DateServiceProvider',
		    'facades' => [
			    'Carbon' => 'Jenssegers\Date\Date',
		    ]
		],

	]
];

//		// overrides
//
//		'Auth'              => 'PragmaRX\SDK\Services\Auth\Facade',
//		'Authentication'    => 'PragmaRX\SDK\Services\Auth\Facade',
//		'DeepScraper'       => 'PragmaRX\SDK\Services\Scraper\DeepScraperFacade',
