<?php

use App\Payments\Model\InvoiceDescription;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalInvoiceDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_invoice_description', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        $serviceLinkType = new InvoiceDescription();
        $serviceLinkType->name = '1st Payment';
        $serviceLinkType->save();

        $serviceLinkType = new InvoiceDescription();
        $serviceLinkType->name = '2st Payment';
        $serviceLinkType->save();

        $serviceLinkType = new InvoiceDescription();
        $serviceLinkType->name = '3rd Payment';
        $serviceLinkType->save();

        $serviceLinkType = new InvoiceDescription();
        $serviceLinkType->name = 'Final Payment';
        $serviceLinkType->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_invoice_description');
    }
}
