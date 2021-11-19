<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralOptionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_pickup_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('address');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();
        });

        Schema::create('general_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('question');
            $table->unsignedInteger('form_step');
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
        Schema::dropIfExists('general_pickup_locations');
        Schema::dropIfExists('general_questions');
    }
}
