<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWeekAndTimeInOtherInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule', function (Blueprint $table) {
            $table->string('first_week')->nullable(true)->after('current_step');
            $table->string('first_time')->nullable(true)->after('first_week');

            $table->string('second_week')->nullable(true)->after('first_time');
            $table->string('second_time')->nullable(true)->after('second_week');

            $table->string('third_week')->nullable(true)->after('second_time');
            $table->string('third_time')->nullable(true)->after('third_week');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_wedding_schedule', function (Blueprint $table) {
            //
        });
    }
}
