<?php
namespace App\Customer\Http\Controllers\Admin;

use Customer;

class PrintController extends \WFN\Admin\Http\Controllers\Controller
{

    public function printContacts(Customer $customer)
    {
        return view('admin.customer.print.contacts', compact('customer'));
    }

    public function printWeddingChecklist(Customer $customer)
    {
        return view('admin.customer.print.wedding_checklist', compact('customer'));
    }

    public function printWeddingSchedule(Customer $customer)
    {
        return view('admin.customer.print.wedding_schedule', compact('customer'));
    }

    public function printNewlywedDetails(Customer $customer)
    {
        return view('admin.customer.print.newlywed_details', compact('customer'));
    }

}
