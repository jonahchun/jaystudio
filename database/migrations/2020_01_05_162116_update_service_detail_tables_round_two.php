<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateServiceDetailTablesRoundTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_thank_you_card_detail', function (Blueprint $table) {
            $table->unsignedTinyinteger('layout_type')->nullable(true)->after('service_id');
        });
        Schema::table('service_photo_album_detail', function (Blueprint $table) {
            $types = \App\Album\Model\Source\Type::getInstance()->getOptions();
            $table->enum('type', array_keys($types))->nullable(true)->after('service_id');
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
