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

namespace PragmaRX\SDK\Support\Database;

use PragmaRX\Support\Migration;

class Migrator extends Migration {

	protected $tables = array(
		'sdk_errors',
		'sdk_sessions',
		'sdk_referers',
		'sdk_domains',
		'sdk_routes',
		'sdk_route_paths',
		'sdk_route_path_parameters',
		'sdk_devices',
		'sdk_cookies',
		'sdk_agents',
		'sdk_query_arguments',
		'sdk_queries',
		'sdk_paths',
		'sdk_log',
		'sdk_geoip',
		'sdk_sql_queries',
		'sdk_sql_queries_log',
		'sdk_sql_query_bindings',
		'sdk_sql_query_bindings_parameters',
		'sdk_connections',
		'sdk_events',
		'sdk_events_log',
		'sdk_system_classes',
	);

	protected function migrateUp()
	{
		$this->builder->create(
			'sdk_log',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->bigInteger('session_id')->unsigned()->index();
				$table->bigInteger('path_id')->unsigned()->nullable()->index();
				$table->bigInteger('query_id')->unsigned()->nullable()->index();
				$table->string('method', 10)->index();
				$table->bigInteger('route_path_id')->unsigned()->nullable()->index();
				$table->boolean('is_ajax');
				$table->boolean('is_secure');
				$table->boolean('is_json');
				$table->boolean('wants_json');
				$table->bigInteger('error_id')->unsigned()->nullable()->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_paths',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('path')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_queries',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('query')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_query_arguments',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->bigInteger('query_id')->unsigned()->index();
				$table->string('argument')->index();
				$table->string('value')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_routes',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('name')->index();
				$table->string('action')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_route_paths',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->bigInteger('route_id')->index();
				$table->string('path')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_route_path_parameters',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->bigInteger('route_path_id')->unsigned()->index();
				$table->string('parameter')->index();
				$table->string('value')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_agents',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('name')->unique();
				$table->string('browser')->index();
				$table->string('browser_version');

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_cookies',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('uuid')->unique();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_devices',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('kind', 16)->index();
				$table->string('model', 64)->index();
				$table->string('platform', 64)->index();
				$table->string('platform_version', 16)->index();
				$table->boolean('is_mobile');

				$table->unique(['kind', 'model', 'platform', 'platform_version']);

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_referers',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->bigInteger('domain_id')->unsigned()->index();
				$table->string('url')->index();
				$table->string('host');

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_domains',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('name')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_sessions',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('uuid')->unique()->index();
				$table->bigInteger('user_id')->unsigned()->nullable()->index();
				$table->bigInteger('device_id')->unsigned()->nullable()->index();
				$table->bigInteger('agent_id')->unsigned()->nullable()->index();
				$table->string('client_ip')->index();
				$table->bigInteger('referer_id')->unsigned()->nullable()->index();
				$table->bigInteger('cookie_id')->unsigned()->nullable()->index();
				$table->bigInteger('geoip_id')->unsigned()->nullable()->index();
				$table->boolean('is_robot');

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_errors',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('code')->index();
				$table->string('message')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_geoip',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->double('latitude')->nullable()->index();
				$table->double('longitude')->nullable()->index();

				$table->string('country_code', 2)->nullable()->index();
				$table->string('country_code3', 3)->nullable()->index();
				$table->string('country_name')->nullable()->index();
				$table->string('region', 2)->nullable();
				$table->string('city', 50)->nullable()->index();
				$table->string('postal_code', 20)->nullable();
				$table->bigInteger('area_code')->nullable();
				$table->double('dma_code')->nullable();
				$table->double('metro_code')->nullable();
				$table->string('continent_code', 2)->nullable();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_sql_queries',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('sha1', 40)->index();
				$table->text('statement');
				$table->double('time')->index();
				$table->integer('connection_id')->unsigned();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_sql_query_bindings',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('sha1', 40)->index();
				$table->text('serialized');

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_sql_query_bindings_parameters',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->bigInteger('sql_query_bindings_id')->unsigned()->nullable();
				$table->string('name')->nullable()->index();
				$table->text('value')->nullable();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_sql_queries_log',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->bigInteger('log_id')->unsigned()->index();
				$table->bigInteger('sql_query_id')->unsigned()->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_connections',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('name')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_events',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('name')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_events_log',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->bigInteger('event_id')->unsigned()->index();
				$table->bigInteger('class_id')->unsigned()->nullable()->index();
				$table->bigInteger('log_id')->unsigned()->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);

		$this->builder->create(
			'sdk_system_classes',
			function ($table)
			{
				$table->bigIncrements('id');

				$table->string('name')->index();

				$table->timestamp('created_at')->index();
				$table->timestamp('updated_at')->index();
			}
		);
	}

	protected function migrateDown()
	{
		$this->dropAllTables();
	}
}
