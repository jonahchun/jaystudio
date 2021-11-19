<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullForNewFieldInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_ceremony', function (Blueprint $table) {
            $table->string('name_of_ceremony')->nullable(true)->after('schedule_id')->change();
        });
        Schema::table('customer_wedding_schedule_preparation', function (Blueprint $table) {
            $table->unsignedBigInteger('hair_makeup')->nullable(true)->after('type')->change();
        });
        Schema::table('customer_wedding_schedule_reception', function (Blueprint $table) {
            $table->string('name_of_reception')->nullable(true)->after('schedule_id')->change();
        });
        Schema::table('customer_wedding_schedule_portrait_session', function (Blueprint $table) {
            $table->string('name_of_ceremony_portrait')->nullable(true)->after('portrait_end_time')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
