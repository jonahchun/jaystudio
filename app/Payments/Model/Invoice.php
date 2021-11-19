<?php

namespace App\Payments\Model;

use Illuminate\Database\Eloquent\Model;

use PayPal\Api\Invoice as PayPalInvoice;

use Customer;

class Invoice extends Model
{

    protected $table = 'invoices';

    protected $fillable = ['customer_id', 'payer_id', 'type', 'invoice_id', 'paypal_invoice_id',
        'status', 'due_date', 'item_description', 'amount', 'tax_amount'];

    protected $dates = ['due_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function paypal_data()
    {
        if($this->type == Source\Type::PAYPAL) {
            try {
                return PayPalInvoice::get($this->paypal_invoice_id, PayPal\Api::getApiContext());
            } catch (\Exception $e) {
                // pass
            }
        }
        return false;
    }

    public function getPayerAttribute($value)
    {
        $value = explode('_', $this->payer_id);
        switch($value[0]) {
            case 'newlywed':
                return \App\Customer\Model\Newlywed::findOrFail($value[1]);
            case 'contact':
                return \App\Customer\Model\Contact::findOrFail($value[1]);
        }
        return false;
    }

    public function getTotalAttribute($value)
    {
        return $this->amount + $this->tax_amount;
    }

    public function getDueAmountAttribute($value)
    {
        return $this->status == Source\Status::PAID ? 0 : $this->total;
    }

    public function getPaidAmountAttribute($value)
    {
        return $this->status == Source\Status::PAID ? $this->total : 0;
    }

    public function save(array $options = [])
    {
        if(!$this->paypal_invoice_id && $this->type == Source\Type::PAYPAL) {
            $this->_createPaypalInvoice();
        }

        if(!$this->invoice_id) {
            $this->_generateInvoiceId();
        }

        return parent::save($options);
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['due_date_formated'] = $this->due_date->format('M jS, Y');
        $data['status_label'] = Source\Status::getInstance()->getOptionLabel($this->status);
        return $data;
    }

    protected function _generateInvoiceId()
    {
        $iterator = 1;
        $this->invoice_id = $this->due_date->format('Ymd') . '-' . $iterator++;
        $exists = static::where('invoice_id', $this->invoice_id)->count();
        while($exists) {
            $this->invoice_id = $this->due_date->format('Ymd') . '-' . $iterator++;
            $exists = static::where('invoice_id', $this->invoice_id)->count();
        }
        return $this;
    }

    protected function _createPaypalInvoice()
    {
        $invoice = PayPal\Api::getPayPalInvoice($this);
        $apiContext = PayPal\Api::getApiContext();
        $invoice->create($apiContext);
        $invoice->send($apiContext);
        $this->paypal_invoice_id = $invoice->id;
    }

}