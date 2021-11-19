<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeddingSchedulePreparationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wedding_schedule_preparation_settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->string('identifier');
            $table->unsignedInteger('sort_order')->nullable(true);

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
        Schema::dropIfExists('wedding_schedule_preparation_settings');
    }
}
