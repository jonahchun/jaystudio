<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewlywedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_newlywed', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');

            $table->string('type')->nullable(true);
            $table->string('bridegroom')->nullable(true);
            $table->string('avatar')->nullable(true);
            $table->string('first_name')->nullable(true);
            $table->string('last_name')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('phone')->nullable(true);

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
        Schema::dropIfExists('customer_newlywed');
    }
}
