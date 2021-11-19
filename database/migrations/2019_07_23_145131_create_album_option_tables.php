<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumOptionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();
        });

        Schema::create('album_core_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedInteger('photos_count');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();
        });

        Schema::create('album_luxe_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();
        });

        Schema::create('album_luxe_type_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('album_luxe_type_id');
            $table->text('image');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();

            $table->foreign('album_luxe_type_id')
                ->references('id')
                ->on('album_luxe_types')
                ->onDelete('cascade');
        });

        Schema::create('album_vintage_covers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('album_luxe_type_id');
            
            $table->text('title');
            $table->text('thumbnail');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();

            $table->foreign('album_luxe_type_id')
                ->references('id')
                ->on('album_luxe_types')
                ->onDelete('cascade');
        });

        Schema::create('album_black_matte_covers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('album_luxe_type_id');
            
            $table->text('title');
            $table->text('thumbnail');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();

            $table->foreign('album_luxe_type_id')
                ->references('id')
                ->on('album_luxe_types')
                ->onDelete('cascade');
        });

        Schema::create('album_atr_deco_colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('album_luxe_type_id');
            
            $table->text('title');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();

            $table->foreign('album_luxe_type_id')
                ->references('id')
                ->on('album_luxe_types')
                ->onDelete('cascade');
        });

        Schema::create('album_atr_deco_patterns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('album_luxe_type_id');
            
            $table->text('title');
            $table->text('thumbnail');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();

            $table->foreign('album_luxe_type_id')
                ->references('id')
                ->on('album_luxe_types')
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
        Schema::dropIfExists('album_sizes');
        Schema::dropIfExists('album_core_types');
        Schema::dropIfExists('album_luxe_types');
        Schema::dropIfExists('album_luxe_type_images');
        Schema::dropIfExists('album_vintage_covers');
        Schema::dropIfExists('album_black_mate_covers');
        Schema::dropIfExists('album_atr_deco_colors');
        Schema::dropIfExists('album_atr_deco_patterns');
    }
}
