<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeddingChecklistTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wedding_checklist_vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();
        });

        Schema::create('customer_wedding_checklist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');

            $table->text('preparation');
            $table->text('ceremony');
            $table->text('portrait_session');
            $table->text('reception');
            $table->text('vendors');

            $table->text('comment');
            $table->string('file')->nullable(true);
            $table->tinyInteger('current_step');
            $table->timestamps();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customer')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wedding_checklist_items');
        Schema::dropIfExists('wedding_checklist_vendors');
        Schema::dropIfExists('customer_wedding_checklist');
    }
}
