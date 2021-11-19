<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompletionColumnToServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_photo_album_detail', function (Blueprint $table) {
            $table->date('completion')->nullable(true)->after('service_id');
        });
        Schema::table('service_save_the_date_card_detail', function (Blueprint $table) {
            $table->date('completion')->nullable(true)->after('service_id');
        });
        Schema::table('service_thank_you_card_detail', function (Blueprint $table) {
            $table->date('completion')->nullable(true)->after('service_id');
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
