<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameOfCeremonyInCustomerWeddingScheduleCeremony extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_ceremony', function (Blueprint $table) {
            $table->string('name_of_ceremony');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_wedding_schedule_ceremony', function (Blueprint $table) {
            //
        });
    }
}
