<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('readings', function (Blueprint $table) {
            $table->string('virtual_meter_name');
            $table->string('node_id');
            $table->string('serial_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('readings', function (Blueprint $table) {
            $table->dropColumn('virtual_meter_name');
            $table->dropColumn('node_id');
            $table->dropColumn('serial_number');
        });
    }
};
