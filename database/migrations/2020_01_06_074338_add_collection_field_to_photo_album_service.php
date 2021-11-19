<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollectionFieldToPhotoAlbumService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_photo_album_detail', function (Blueprint $table) {
            $types = \App\Album\Model\Source\Collection::getInstance()->getOptions();
            $table->enum('collection', array_keys($types))->nullable(true)->after('type');
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
