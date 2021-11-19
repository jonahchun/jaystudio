<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortraitSessionLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_wedding_schedule_portrait_session_location', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('portrait_session_id');
            $table->unsignedBigInteger('address_id');
            $table->string('name_of_ceremony_portrait');
            $table->string('portrait_start_time')->nullable(true);
            $table->string('portrait_end_time')->nullable(true);
            $table->timestamps();
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
