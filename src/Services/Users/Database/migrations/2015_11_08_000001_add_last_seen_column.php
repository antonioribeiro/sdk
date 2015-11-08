<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLastSeenColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function migrateUp() {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('last_seen_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function migrateDown() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_seen_at');
        });
    }
}
