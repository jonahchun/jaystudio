<?php

use App\Payments\Model\InvoiceDescription;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaypalInvoiceDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $serviceLinkType = InvoiceDescription::where('name', '2st Payment')->first();
        $serviceLinkType->name = '2nd Payment';
        $serviceLinkType->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $serviceLinkType = InvoiceDescription::where('name', '2nd Payment')->first();
        $serviceLinkType->name = '2st Payment';
        $serviceLinkType->save();
    }
}
