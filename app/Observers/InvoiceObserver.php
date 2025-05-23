<?php

namespace App\Observers;

use App\Payments\Model\Invoice;
use App\Payments\Model\Source\Status;
use Illuminate\Support\Facades\Log;

class InvoiceObserver
{
    public function updated(Invoice $invoice)
    {
        if ($invoice->isDirty('status') && (int)$invoice->status === Status::PAID) {
            $this->sendPaymentReceivedEmail($invoice);
        }
    }

    protected function sendPaymentReceivedEmail(Invoice $invoice)
    {
        $data = [
            'first_newlywed_name' => $invoice->customer->first_newlywed->first_name,
            'second_newlywed_name' => $invoice->customer->second_newlywed->first_name,
            'id' => $invoice->id,
            'amount' => $invoice->amount,
        ];

        Log::info('Email sent: "Payment received". Data: ' . print_r($data, true));

        \MandrillMail::send('payment-received', $invoice->customer->email, $data);
    }
}
