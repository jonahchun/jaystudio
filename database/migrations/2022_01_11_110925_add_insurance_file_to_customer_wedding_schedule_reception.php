<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInsuranceFileToCustomerWeddingScheduleReception extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_reception', function (Blueprint $table) {
            $table->tinyInteger('insurance_certificate')->nullable(true)->after('timeline_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_wedding_schedule_reception', function (Blueprint $table) {
            //
        });
    }
}
