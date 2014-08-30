<?php
/**
 * Part of the Sdk package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sdk
 * @author     Antonio Carlos Ribeiro @ PragmaRX
 * @license    BSD License (3-clause)
 * @copyright  (c) 2013, PragmaRX
 * @link       http://pragmarx.com
 */

return [

	'application_services_path' => app_path() . '/Services/',

	'files_path' => public_path() . '/files/',

	'models' => [
		'user' => 'PragmaRX\Sdk\Services\Users\Data\Entities\User',
	],

	'services' => [
		'Services/Accounts',

		'Services/Block',

		'Services/Cities',
		'Services/Connect',
		'Services/ContactInformation',
		'Services/Countries',
		'Services/Currencies',

		'Services/EmailChanges',

		'Services/Files',
		'Services/Follow',

		'Services/Kinds',

		'Services/Login',

		'Services/Messaging',

		'Services/Passwords',
		'Services/Profiles',

		'Services/Registration',

		'Services/States',
		'Services/Statuses',

		'Services/Users',
	],

	'disabled.packages' => [

	],

	'packages' => [

		[
			'name' => 'pragmarx/avatar',
			'enabled' => true,
			'serviceProvider' => 'PragmaRX\Sdk\Services\Avatars\Service\Provider',
			'facades' => [
				'Avatar' => 'PragmaRX\Sdk\Services\Avatars\Service\Facade',
			]
		],

		[
			'name' => 'pragmarx/file',
			'enabled' => true,
			'serviceProvider' => 'PragmaRX\Sdk\Services\Files\Service\Provider',
			'facades' => [
				'File' => 'PragmaRX\Sdk\Services\Files\Service\Facade', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/auth',
			'enabled' => true,
		    'serviceProvider' => 'PragmaRX\Sdk\Services\Auth\Service\Provider',
			'facades' => [
				'Authentication' => 'PragmaRX\Sdk\Services\Auth\Service\Facade',
				'Auth'           => 'PragmaRX\Sdk\Services\Auth\Service\Facade', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/redirect',
			'enabled' => true,
			'facades' => [
				'Redirect' => 'PragmaRX\Sdk\Core\Redirect', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/form',
			'enabled' => true,
			'serviceProvider' => 'PragmaRX\Sdk\Services\Form\Service\Provider',
			'facades' => [
				'Form' => 'PragmaRX\Sdk\Services\Form\Service\Facade', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/html',
			'enabled' => true,
			'facades' => [
				'Html' => 'PragmaRX\Sdk\Services\Html\Service\Facade', /// overrides the Laravel Facade
				'HTML' => 'PragmaRX\Sdk\Services\Html\Service\Facade', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/flash',
			'enabled' => true,
		    'serviceProvider' => 'PragmaRX\Sdk\Services\Flash\Service\Provider',
			'facades' => [
				'Flash' => 'PragmaRX\Sdk\Services\Flash\Service\Facade',
			]
		],

//		[
//			'name' => 'pragmarx/tracker',
//			'enabled' => true,
//		    'serviceProvider' => 'PragmaRX\Tracker\Vendor\Laravel\ServiceProvider',
//		],

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
