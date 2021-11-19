<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMagnetFlagToOrderForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_save_the_date_card_detail', function (Blueprint $table) {
            $table->boolean('is_magnet')->after('format')->default(false);
        });
        Schema::table('service_thank_you_card_detail', function (Blueprint $table) {
            $table->boolean('is_magnet')->after('format')->default(false);
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
