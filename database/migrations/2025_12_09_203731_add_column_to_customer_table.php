<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCustomerTable extends Migration
{
    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
