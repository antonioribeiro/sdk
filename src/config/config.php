<?php

return [

	'enabled' => true,

	'application_services_path' => app_path() . '/Services/',

	'files_path' => public_path() . '/files/',

	'aliases' => [
		'activation'    => 'PragmaRX\Sdk\Services\Users\Data\Entities\UserActivation',
		'persistence'   => 'PragmaRX\Sdk\Services\Users\Data\Entities\Persistence',
		'reminder'      => 'PragmaRX\Sdk\Services\Users\Data\Entities\Reminder',
		'role'          => 'PragmaRX\Sdk\Services\Users\Data\Entities\Role',
		'throttle'      => 'PragmaRX\Sdk\Services\Users\Data\Entities\Throttle',
		// 'user'          => 'PragmaRX\Sdk\Services\Users\Data\Entities\User',
		'user'          => 'ConsultorioDigital\Services\Users\Data\Entities\User',
	],

	'services' => [
		'Services/Accounts',
		'Services/Addresses',
		'Services/Activation',

		'Services/Billing',
		'Services/Block',
		'Services/Bus',

		'Services/Categories',
		'Services/Chat',
		'Services/Cities',
		'Services/Clients',
		'Services/Clipping',
		'Services/Connect',
		'Services/ContactInformation',
		'Services/Countries',
		'Services/Currencies',

		'Services/EmailChanges',
		'Services/ExceptionHandler',

		'Services/Files',
		'Services/Firewall',
		'Services/Follow',

		'Services/Groups',

		'Services/Kinds',

		'Services/Language',
		'Services/Login',

		'Services/Mailer',
		'Services/Messages',

		'Services/Notifications',

		'Services/Passwords',
		'Services/Permissions',
		'Services/Products',
		'Services/Profiles',

		'Services/Registration',
		'Services/Roles',

		'Services/Settings',
		'Services/Sms',
		'Services/States',
		'Services/Statuses',
		'Services/Security',
		'Services/SystemEntities',

		'Services/Tags',
		'Services/TwoFactor',
		'Services/Translator',

		'Services/Users',

		'Services/View',

		'Services/Zip',
	],

	'disabled.packages' => [
		'pragmarx/tracker'
	],

	'packages' => [

		[
			'name' => 'pragmarx/push',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Push\Service\Provider'],
			'facades' => ['Push' => 'PragmaRX\Sdk\Services\Push\Service\Facade']
		],

		[
			'name' => 'pragmarx/exception',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\ExceptionHandler\Service\Provider'],
			'facades' => ['ExceptionHandler' => 'PragmaRX\Sdk\Services\ExceptionHandler\Service\Facade']
		],

		[
			'name' => 'pragmarx/redirect',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Redirect\Service\Provider'],
			'facades' => []
		],

		[
			'name' => 'pragmarx/google2fa',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Google2FA\Vendor\Laravel\ServiceProvider'],
			'facades' => [
				'Google2FA' => 'PragmaRX\Google2FA\Vendor\Laravel\Facade',
			]
		],

		[
			'name' => 'pragmarx/sdk/registration',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Registration\Service\Provider'],
			'facades' => [
				'Registration' => 'PragmaRX\Sdk\Services\Registration\Service\Facade',
			]
		],

		[
			'name' => 'pragmarx/sdk/bus',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Bus\Service\Provider'],
			'facades' => []
		],

		[
			'name' => 'pragmarx/sms',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Sms\Service\Provider'],
			'facades' => [
				'Sms' => 'PragmaRX\Sdk\Services\Sms\Service\Facade',
			]
		],

		[
			'name' => 'pragmarx/language',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Language\Service\Provider'],
			'facades' => [
				'Language' => 'PragmaRX\Sdk\Services\Language\Service\Facade',
			]
		],

		[
			'name' => 'pragmarx/view',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\View\Service\Provider'],
		],

		[
			'name' => 'pragmarx/translator',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Translator\Service\Provider'],
			'facades' => [
				// 'Lang' => 'PragmaRX\Sdk\Services\Translator\Service\Facade',
			]
		],

		[
			'name' => 'pragmarx/zipcode',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\ZipCode\Vendor\Laravel\ServiceProvider'],
			'facades' => [
				'ZipCode' => 'PragmaRX\ZipCode\Vendor\Laravel\Facade',
			]
		],

		[
			'name' => 'pragmarx/avatar',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Avatars\Service\Provider'],
			'facades' => [
				'Avatar' => 'PragmaRX\Sdk\Services\Avatars\Service\Facade',
			]
		],

		[
			'name' => 'pragmarx/file',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Files\Service\Provider'],
			'facades' => [
				'File' => 'PragmaRX\Sdk\Services\Files\Service\Facade', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/auth',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Auth\Service\Provider'],
			'facades' => [
				'Authentication' => 'PragmaRX\Sdk\Services\Auth\Service\Facade',
				'Auth'           => 'PragmaRX\Sdk\Services\Auth\Service\Facade', /// overrides the Laravel Facade
			]
		],

		[
			'name' => 'pragmarx/activation',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Activation\Service\Provider'],
			'facades' => [
				'Activation' => 'PragmaRX\Sdk\Services\Activation\Service\Facade',
			]
		],

		[
			'name' => 'pragmarx/form',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Sdk\Services\Form\Service\Provider'],
			'facades' => [
				'Form' => 'PragmaRX\Sdk\Services\Form\Service\FormFacade',
				'Html' => 'PragmaRX\Sdk\Services\Form\Service\HtmlFacade',
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
			'serviceProviders' => ['PragmaRX\Sdk\Services\Flash\Service\Provider'],
			'facades' => [
				'Flash' => 'PragmaRX\Sdk\Services\Flash\Service\Facade',
			]
		],

		[
			'name' => 'pragmarx/tracker',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Tracker\Vendor\Laravel\ServiceProvider'],
		],

		[
			'name' => 'pragmarx/firewall',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Firewall\Vendor\Laravel\ServiceProvider'],
		],

		[
			'name' => 'pragmarx/sqli',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\SqlI\Vendor\Laravel\ServiceProvider'],
		],

		[
			'name' => 'pragmarx/glottos',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\Glottos\Vendor\Laravel\ServiceProvider'],
		],

		[
			'name' => 'way/generators',
			'enabled' => true,
			'serviceProviders' => ['Way\Generators\GeneratorsServiceProvider'],
		],

		[
			'name' => 'laracasts/commander',
			'enabled' => true,
			'serviceProviders' => ['Laracasts\Commander\CommanderServiceProvider'],
		],

		[
			'name' => 'laracasts/validation',
			'enabled' => true,
			'serviceProviders' => ['Laracasts\Validation\ValidationServiceProvider'],
		],

		[
			'name' => 'laracasts/utilities',
			'enabled' => true,
			'serviceProviders' => ['Laracasts\Utilities\UtilitiesServiceProvider'],
		],

		//		[
		//			'name' => 'cartalyst/sentinel',
		//			'enabled' => true,
		//			'serviceProviders' => ['Cartalyst\Sentinel\Laravel\SentinelServiceProvider'],
		//		    'facades' => [
		//				'Activation' => 'Cartalyst\Sentinel\Laravel\Facades\Activation',
		//				'Reminder'   => 'Cartalyst\Sentinel\Laravel\Facades\Reminder',
		//				'Sentinel'   => 'Cartalyst\Sentinel\Laravel\Facades\Sentinel',
		//		    ]
		//		],

		[
			'name' => 'jenssegers/date',
			'enabled' => true,
			'serviceProviders' => ['Jenssegers\Date\DateServiceProvider'],
			'facades' => [
				'Carbon' => 'Jenssegers\Date\Date',
			]
		],

		[
			'name' => 'aloha/twilio',
			'enabled' => true,
			'serviceProviders' => ['Aloha\Twilio\TwilioServiceProvider'],
			'facades' => [
				'Twilio' => 'Aloha\Twilio\Facades\Twilio',
			]
		],

		[
			'name' => 'way/generators',
			'enabled' => true,
			'serviceProviders' => ['Way\Generators\GeneratorsServiceProvider'],
		],

		[
			'name' => 'pragmarx/sqli',
			'enabled' => true,
			'serviceProviders' => ['PragmaRX\SqlI\Vendor\Laravel\ServiceProvider'],
		],

		[
			'name' => 'illuminate/html',
			'enabled' => true,
			'serviceProviders' => ['Illuminate\Html\HtmlServiceProvider'],
		],

		//		[
		//			'name' => 'barryvdh/translationmanager',
		//			'enabled' => true,
		//			'serviceProviders' => ['Barryvdh\TranslationManager\ManagerServiceProvider'],
		//		],

	]
];
