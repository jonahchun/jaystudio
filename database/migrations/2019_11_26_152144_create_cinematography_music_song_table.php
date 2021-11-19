<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCinematographyMusicSongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_wedding_schedule_music_song', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('schedule_id');
            $table->string('song_name')->nullable(true);
            $table->string('type')->nullable(true);

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
