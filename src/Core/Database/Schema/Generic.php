<?php

namespace PragmaRX\Sdk\Core\Database\Schema;


trait Generic {

	public function businessDaysAndHoursUp($table)
	{
		$table->string('business_days',7)->default('12345'); // 0 = Sunday

		$table->string('business_hours_start',5)->default('07:00');

		$table->string('business_hours_end',5)->default('20:00');
	}

	public function businessDaysAndHoursDown($tableName)
	{
		$this->dropColumn($tableName, 'business_days');

		$this->dropColumn($tableName, 'business_hours_start');

		$this->dropColumn($tableName, 'business_hours_end');
	}

}
