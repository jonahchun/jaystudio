<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameOfCeremonyInCustomerWeddingSchedulePortraitSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_portrait_session', function (Blueprint $table) {
            $table->string('name_of_ceremony_portrait');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_wedding_schedule_portrait_session', function (Blueprint $table) {
            //
        });
    }
}
