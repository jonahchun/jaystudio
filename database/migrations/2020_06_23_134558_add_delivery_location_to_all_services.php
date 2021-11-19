<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryLocationToAllServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_save_the_date_card_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_location_id')->nullable(true)->after('comment');
            $table->foreign('delivery_location_id')
                ->references('id')
                ->on('general_pickup_locations')
                ->onDelete('set null');
        });

        Schema::table('service_thank_you_card_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_location_id')->nullable(true)->after('comment');
            $table->foreign('delivery_location_id')
                ->references('id')
                ->on('general_pickup_locations')
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

    }
}
