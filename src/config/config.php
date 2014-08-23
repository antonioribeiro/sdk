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

	'files_path' => public_path() . '/files/',

	'models' => [
		'user' => 'PragmaRX\SDK\Services\Users\Data\Entities\User',
	],

	'services' => [
		'Services/Registration',
		'Services/Login',
		'Services/Messaging',
	    'Services/Accounts',
	    'Services/Passwords',
	    'Services/Profiles',
	    'Services/Follow',
	    'Services/Connect',
	    'Services/Block',
	    'Services/Users',
	    'Services/Statuses',
	    'Services/EmailChanges',
	    'Services/Files',
	],

	'disabled.packages' => [

	],

	'packages' => [

		[
			'name' => 'pragmarx/file',
			'enabled' => true,
			'serviceProvider' => 'PragmaRX\SDK\Services\Files\Service\Provider',
			'facades' => [
				'File' => 'PragmaRX\SDK\Services\Files\Service\Facade', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/auth',
			'enabled' => true,
		    'serviceProvider' => 'PragmaRX\SDK\Services\Auth\Service\Provider',
			'facades' => [
				'Authentication' => 'PragmaRX\SDK\Services\Auth\Service\Facade',
				'Auth'           => 'PragmaRX\SDK\Services\Auth\Service\Facade', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/redirect',
			'enabled' => true,
			'facades' => [
				'Redirect' => 'PragmaRX\SDK\Core\Redirect', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/form',
			'enabled' => true,
			'serviceProvider' => 'PragmaRX\SDK\Services\Form\Service\Provider',
			'facades' => [
				'Form' => 'PragmaRX\SDK\Services\Form\Service\Facade', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/flash',
			'enabled' => true,
		    'serviceProvider' => 'PragmaRX\SDK\Services\Flash\Service\Provider',
			'facades' => [
				'Flash' => 'PragmaRX\SDK\Services\Flash\Service\Facade',
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
