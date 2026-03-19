<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueIndexToAccountIdInCustomers extends Migration
{
    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->string('account_id')->unique()->change();
        });
    }

    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropUnique(['account_id']);
        });
    }

}
