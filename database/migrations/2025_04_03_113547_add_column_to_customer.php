<?php

use App\Core\Model\OnlineGalleryLink;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $galleryLink = OnlineGalleryLink::first();
        if(!$galleryLink){
            echo "Something Wrong! No one link found";
            die;
        }

        Schema::table('customer', function (Blueprint $table) use ($galleryLink) {
            $table->integer('online_gallery_link_id')->nullable()->default($galleryLink->id);
        });

        $newLink = new OnlineGalleryLink();
        $newLink->url = 'New-gallery-link';
        $newLink->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn('online_gallery_id');
        });
    }
}
