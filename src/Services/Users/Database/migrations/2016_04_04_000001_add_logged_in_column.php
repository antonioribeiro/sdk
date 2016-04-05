<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLoggedInColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function migrateUp()
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->boolean('logged_in')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function migrateDown()
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn('logged_in');
        });
    }
}
