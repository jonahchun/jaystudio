<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumLuxeTypeSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_luxe_type_sizes', function($table) {
            $table->unsignedBigInteger('album_luxe_type_id');
            $table->unsignedBigInteger('album_size_id');
            $table->timestamps();

            $table->foreign('album_luxe_type_id')
                ->references('id')
                ->on('album_luxe_types')
                ->onDelete('cascade');

            $table->foreign('album_size_id')
                ->references('id')
                ->on('album_sizes')
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
        Schema::dropIfExists('album_luxe_type_sizes');
    }
}
