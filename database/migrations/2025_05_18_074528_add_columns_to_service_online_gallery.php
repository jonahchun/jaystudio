<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToServiceOnlineGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_online_gallery', function (Blueprint $table) {
            $table->string('collection_url')->nullable()->after('password');
            $table->string('collection_password')->nullable();
            $table->string('download_pin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_online_gallery', function (Blueprint $table) {
            $table->dropColumn('collection_url');
            $table->dropColumn('collection_password');
            $table->dropColumn('download_pin');
        });
    }
}
