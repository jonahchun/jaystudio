<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCinematographyMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_wedding_schedule_music', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('schedule_id');
            $table->tinyInteger('music')->nullable(true);
            $table->timestamps();

            $table->foreign('schedule_id')
                ->references('id')
                ->on('customer_wedding_schedule')
                ->onDelete('cascade');
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

