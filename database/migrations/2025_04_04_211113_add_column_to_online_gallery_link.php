<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToOnlineGalleryLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_gallery_link', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });

        DB::table('online_gallery_link')->where(['id' => 1])->update(['name' => 'Zenfolio']);
        DB::table('online_gallery_link')->where(['id' => 2])->update(['name' => 'Pixieset']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_gallery_link', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}
