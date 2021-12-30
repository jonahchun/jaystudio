<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHairMakeupToScheduleAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_address', function (Blueprint $table) {
            $table->string('hair_makeup_name')->after('zip')->nullable(true);
            $table->string('hair_makeup_address_line_1')->after('hair_makeup_name')->nullable(true);
            $table->string('hair_makeup_address_line_2')->after('hair_makeup_address_line_1')->nullable(true);
            $table->string('hair_makeup_country')->after('hair_makeup_address_line_2')->nullable(true);
            $table->string('hair_makeup_state')->after('hair_makeup_country')->nullable(true);
            $table->string('hair_makeup_city')->after('hair_makeup_state')->nullable(true);
            $table->string('hair_makeup_zip')->after('hair_makeup_city')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_address', function (Blueprint $table) {
            //
        });
    }
}
