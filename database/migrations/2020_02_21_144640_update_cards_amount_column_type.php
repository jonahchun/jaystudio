<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCardsAmountColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_save_the_date_card_detail', function (Blueprint $table) {
            $table->unsignedSmallInteger('cards_amount')->nullable(true)->change();
        });
        Schema::table('service_thank_you_card_detail', function (Blueprint $table) {
            $table->unsignedSmallInteger('cards_amount')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
