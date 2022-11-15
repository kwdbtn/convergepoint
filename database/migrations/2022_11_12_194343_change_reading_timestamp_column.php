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
            $table->string('timestamp')->nullable()->change();
            $table->string('norm')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('readings', function (Blueprint $table) {
            $table->dateTimeTz('timestamp')->nullable()->change();
            $table->integer('norm')->nullable()->change();
        });
    }
};
