<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Services\Model\Source\Type as ServiceType;

class UpdateServicesTablesRoundThree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_' . ServiceType::PHOTO . '_detail', function (Blueprint $table) {
            $table->string('upload')->nullable(true)->after('service_id');
        });

        Schema::table('service_' . ServiceType::VIDEO . '_detail', function (Blueprint $table) {
            $table->string('upload')->nullable(true)->after('service_id');
        });

        Schema::table('service_' . ServiceType::PHOTO_ALBUM . '_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('core_type_id')->after('type')->nullable(true);
            $table->unsignedBigInteger('luxe_type_id')->after('core_type_id')->nullable(true);
            $table->unsignedBigInteger('size_id')->after('luxe_type_id')->nullable(true);
            $table->string('other_size')->after('size_id')->nullable(true);
            $table->unsignedBigInteger('vintage_cover_id')->after('other_size')->nullable(true);
            $table->unsignedBigInteger('black_matte_cover_id')->after('vintage_cover_id')->nullable(true);
            $table->unsignedBigInteger('art_deco_color_id')->after('black_matte_cover_id')->nullable(true);
            $table->unsignedBigInteger('art_deco_pattern_id')->after('art_deco_color_id')->nullable(true);

            $table->string('leather_text')->after('art_deco_pattern_id')->nullable(true);
            $table->string('art_deco_cover_image')->after('leather_text')->nullable(true);
            $table->string('acrylic_cover_image')->after('art_deco_cover_image')->nullable(true);

            $table->text('images')->after('acrylic_cover_image')->nullable(true);

            $table->foreign('core_type_id')
                ->references('id')
                ->on('album_core_types')
                ->onDelete('set null');
            
            $table->foreign('luxe_type_id')
                ->references('id')
                ->on('album_luxe_types')
                ->onDelete('set null');
            
            $table->foreign('size_id')
                ->references('id')
                ->on('album_sizes')
                ->onDelete('set null');
            
            $table->foreign('vintage_cover_id')
                ->references('id')
                ->on('album_vintage_covers')
                ->onDelete('set null');
            
            $table->foreign('black_matte_cover_id')
                ->references('id')
                ->on('album_black_matte_covers')
                ->onDelete('set null');
            
            $table->foreign('art_deco_color_id')
                ->references('id')
                ->on('album_atr_deco_colors')
                ->onDelete('set null');
            
            $table->foreign('art_deco_pattern_id')
                ->references('id')
                ->on('album_atr_deco_patterns')
                ->onDelete('set null');
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
