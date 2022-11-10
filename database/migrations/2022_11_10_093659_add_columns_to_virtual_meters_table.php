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
        Schema::table('virtual_meters', function (Blueprint $table) {
            $table->integer('customer_id')->unsigned()->nullable()->after('serial_number');
            $table->integer('feeder_id')->unsigned()->nullable()->after('customer_id');
            $table->integer('meter_location_id')->unsigned()->nullable()->after('feeder_id');
            $table->string('type')->nullable()->after('meter_location_id');
            $table->boolean('active')->default(true)->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('virtual_meters', function (Blueprint $table) {
            $table->dropColumn('customer_id')->unsigned()->nullable();
            $table->dropColumn('feeder_id')->unsigned()->nullable();
            $table->dropColumn('meter_location_id')->unsigned()->nullable();
            $table->dropColumn('type')->nullable();
            $table->dropColumn('active')->default(true)->nullable();
        });
    }
};
