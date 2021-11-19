<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHairMakeupInCustomerWeddingSchedulePreparation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_preparation', function (Blueprint $table) {
            $table->unsignedBigInteger('hair_makeup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_wedding_schedule_preparation', function (Blueprint $table) {
            //
        });
    }
}
