<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');

        Schema::table('customer_details', function($table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');

            $table->string('account_id')->nullable(true)->after('customer_id');
            $table->date('wedding_date')->nullable(true)->after('account_id');
            $table->string('contract')->nullable(true)->after('wedding_date');
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
