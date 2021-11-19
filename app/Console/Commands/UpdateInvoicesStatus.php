<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Payments\Model\Invoice;
use App\Payments\Model\Source\Type;
use App\Payments\Model\Source\Status;

class UpdateInvoicesStatus extends Command
{

    const PAYPAL_PAID_STATUS = 'PAID';

    protected $signature = 'invoices:update_status';

    protected $description = 'Update invoices status';

    public function handle()
    {
        $this->_processOfflineInvoices();
        $this->_processPaypalInvoices();
    }

    protected function _processOfflineInvoices()
    {
        $invoices = Invoice::where('type', Type::OFFLINE)
            ->where('status', '!=', Status::PAID)
            ->where('due_date', '<', Carbon::now())
            ->get();
        foreach($invoices as $invoice) {
            try {
                $invoice->update(['status' => Status::OVERDUE]);
            } catch (\Exception $e) {
                // pass
            }
        }
    }

    protected function _processPaypalInvoices()
    {
        $paypalInvoices = Invoice::where('type', Type::PAYPAL)
            ->where('status', '!=', Status::PAID)
            ->get();
        foreach($paypalInvoices as $invoice) {
            try {
                if($invoice->due_date->lt(Carbon::now())) {
                    $invoice->update(['status' => Status::OVERDUE]);
                }
                
                if(optional($invoice->paypal_data())->status == self::PAYPAL_PAID_STATUS) {
                    $invoice->update(['status' => Status::PAID]);
                }
            } catch (\Exception $e) {
                // pass
            }
        }
    }
}
