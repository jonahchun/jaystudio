<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePhotoAlbumServiceTablePartTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_photo_album_detail', function (Blueprint $table) {
            $table->dropColumn('type');
            $types = \App\Album\Model\Source\Type::getInstance()->getOptions();
            $table->enum('album_type', array_keys($types))->nullable(true)->after('service_id');
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
