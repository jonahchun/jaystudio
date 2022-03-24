<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInitiallyCompleteToCustomerNewlywedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_newlywed_details', function (Blueprint $table) {
            $table->tinyInteger('initially_complete')->after('current_step')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_newlywed_details', function (Blueprint $table) {
            $table->dropColumn('initially_complete');
        });
    }
}
