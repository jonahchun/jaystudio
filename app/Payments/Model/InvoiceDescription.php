<?php

namespace App\Payments\Model;

use Illuminate\Database\Eloquent\Model;

use PayPal\Api\Invoice as PayPalInvoice;

use Customer;

class InvoiceDescription extends Model
{

    protected $table = 'paypal_invoice_description';

    protected $fillable = ['name', 'active'];


}
