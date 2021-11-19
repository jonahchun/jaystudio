<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultByCurrentStepInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_newlywed_details', function (Blueprint $table) {
            $table->smallInteger('current_step')->tinyInteger('current_step')->default(0)->change();
        });
        Schema::table('customer_wedding_checklist', function (Blueprint $table) {
            $table->smallInteger('current_step')->tinyInteger('current_step')->default(0)->change();
        });
        Schema::table('customer_wedding_schedule', function (Blueprint $table) {
            $table->smallInteger('current_step')->tinyInteger('current_step')->default(0)->change();
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
