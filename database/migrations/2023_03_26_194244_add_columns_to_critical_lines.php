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
        Schema::table('critical_lines', function (Blueprint $table) {
            $table->dateTime('loss_date')->nullable()->after('destination');
            $table->double('loss')->unsigned()->nullable()->after('loss_date');
            $table->boolean('active')->default(true)->nullable()->after('loss');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('critical_lines', function (Blueprint $table) {
            $table->dropColumn('loss_date');
            $table->dropColumn('loss');
            $table->dropColumn('active');
        });
    }
};
