<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerChecklistDbStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wedding_checklist', function (Blueprint $table) {
            $table->text('preparation')->nullable(true)->change();
            $table->text('comment')->nullable(true)->change();
            $table->text('ceremony')->nullable(true)->change();
            $table->text('portrait_session')->nullable(true)->change();
            $table->text('reception')->nullable(true)->change();
            $table->text('vendors')->nullable(true)->change();
            $table->text('current_step')->nullable(true)->change();
//            $table->tinyInteger('current_step')->nullable(true)->change();

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