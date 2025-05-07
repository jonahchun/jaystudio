<?php

use App\Services\Model\ServiceLinkType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceLinkType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_link_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        $serviceLinkType = new ServiceLinkType();
        $serviceLinkType->name = 'Full Video';
        $serviceLinkType->save();

        $serviceLinkType = new ServiceLinkType();
        $serviceLinkType->name = 'Highlight Reel';
        $serviceLinkType->save();

        $serviceLinkType = new ServiceLinkType();
        $serviceLinkType->name = 'Dance Chapter (complimentary)';
        $serviceLinkType->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_link_type');
    }
}
