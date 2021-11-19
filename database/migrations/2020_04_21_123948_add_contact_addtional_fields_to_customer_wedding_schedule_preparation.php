<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactAddtionalFieldsToCustomerWeddingSchedulePreparation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_preparation', function (Blueprint $table) {
            $table->string('contact_name')->after('contact_id')->nullable(true);
            $table->string('contact_phone')->after('contact_name')->nullable(true);
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
