<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->text('field_name')->nullable(true);
            $table->text('old_data')->nullable(true);
            $table->text('new_data')->nullable(true);
            $table->string('form_type')->nullable(true);
            $table->tinyInteger('form_steps')->nullable(true);
            $table->string('field_type')->nullable(true);
            $table->string('customer_type')->nullable(true);
            $table->boolean('is_read')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
