<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJLSTimeToWeddingPreparation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_preparation', function (Blueprint $table) {
            $table->string('jls_start_time')->after('contact_phone')->nullable(true);
            $table->string('jls_end_time')->after('jls_start_time')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wedding_preparation', function (Blueprint $table) {
            //
        });
    }
}
