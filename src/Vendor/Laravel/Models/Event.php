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

namespace PragmaRX\SDK\Vendor\Laravel\Models;

use Carbon\Carbon;

class Event extends Base {

	protected $table = 'sdk_events';

	protected $fillable = array(
		'name',
	);

	public function allInThePeriod($minutes)
	{
		return
			$this
				->select(
					'sdk_events.id',
					'sdk_events.name',
					$this->getConnection()->raw('count(sdk_events_log.id) as total')
				)
				->from('sdk_events')
				->period($minutes, 'sdk_events_log')
				->join('sdk_events_log', 'sdk_events_log.event_id', '=', 'sdk_events.id')
				->groupBy('sdk_events.id', 'sdk_events.name')
				->orderBy('total', 'desc')
				->get();
	}

}
