<?php

namespace App\Payments\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Payments\Model\Invoice;
use App\Payments\Model\Source\Status;

class InvoiceController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index(Request $request)
    {
        $invoices = Auth::user()->invoices()->where('status', Status::DUE)->paginate(7);
        return $request->ajax() ? $invoices : view('payments.invoice.list', compact('invoices'));
    }

    public function view(Invoice $invoice)
    {
        if($invoice->customer->id != Auth::user()->id) {
            return abort(404);
        }
        return view('payments.invoice.view', compact('invoice'));
    }

}
