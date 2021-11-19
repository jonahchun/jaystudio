<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerWeddingSchedulePreparationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_preparation', function (Blueprint $table) {
            $table->dropColumn('emergency_contact');
            $table->unsignedBigInteger('contact_id')->nullable(true)->after('transportation_start_date');

            $table->foreign('contact_id')
                ->references('id')
                ->on('customer_contacts')
                ->onDelete('set null');
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
