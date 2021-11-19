<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPickupLocationColumnToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('pickup_location_id')->nullable(true)->after('status');
            $table->string('tracking_link')->nullable(true)->after('pickup_location_id');
            
            $table->foreign('pickup_location_id')
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
        //
    }
}
