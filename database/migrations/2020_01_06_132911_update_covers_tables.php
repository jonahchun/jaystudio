<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCoversTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('album_atr_deco_colors', function (Blueprint $table) {
            $table->dropForeign('album_atr_deco_colors_album_luxe_type_id_foreign');
            $table->dropColumn('album_luxe_type_id');
        });
        Schema::table('album_atr_deco_patterns', function (Blueprint $table) {
            $table->dropForeign('album_atr_deco_patterns_album_luxe_type_id_foreign');
            $table->dropColumn('album_luxe_type_id');
        });
        Schema::table('album_vintage_covers', function (Blueprint $table) {
            $table->dropForeign('album_vintage_covers_album_luxe_type_id_foreign');
            $table->dropColumn('album_luxe_type_id');
        });
        Schema::table('album_black_matte_covers', function (Blueprint $table) {
            $table->dropForeign('album_black_mate_covers_album_luxe_type_id_foreign');
            $table->dropColumn('album_luxe_type_id');
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
