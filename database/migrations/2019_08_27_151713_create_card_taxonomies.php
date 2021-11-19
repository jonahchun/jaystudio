<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTaxonomies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('title');
            $table->tinyInteger('card_type');
            $table->tinyInteger('sort_order')->nullable(true);

            $table->timestamps();
        });
        Schema::create('card_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('title');
            $table->tinyInteger('card_type');
            $table->string('image');
            $table->tinyInteger('side_type');
            $table->tinyInteger('layout_type');
            $table->tinyInteger('format');
            $table->tinyInteger('sort_order')->nullable(true);

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
        Schema::dropIfExists('card_sizes');
        Schema::dropIfExists('card_templates');
    }
}
