<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullSheduleIdPortraitIdAddressIdInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_address', function (Blueprint $table) {
            $table->bigInteger('portrait_session_location_id')->after('schedule_id')->nullable(true);

        });
        Schema::table('customer_wedding_schedule_portrait_session_location', function (Blueprint $table) {
            $table->string('name_of_ceremony_portrait')->nullable(true)->change();
            $table->bigInteger('portrait_session_id')->nullable(true)->change();
            $table->bigInteger('address_id')->nullable(true)->change();
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
