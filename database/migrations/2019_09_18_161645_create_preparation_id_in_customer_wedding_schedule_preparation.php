<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreparationIdInCustomerWeddingSchedulePreparation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_schedule_preparation', function (Blueprint $table) {
            $table->unsignedBigInteger('preparation_id')->nullable(true);

            $table->foreign('preparation_id')
                ->references('id')
                ->on('wedding_schedule_preparation_settings')
                ->onDelete('set null')
                ->after('schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_wedding_schedule_preparation');
    }
}
