<?php
namespace App\Customer\Http\Controllers\Admin;

use Customer;
use App\Services\Model\Service;

class PrintController extends \WFN\Admin\Http\Controllers\Controller
{

    public function printContacts(Customer $customer)
    {
        return view('admin.customer.print.contacts', compact('customer'));
    }

    public function printWeddingChecklist(Customer $customer)
    {
        $services = Service::select('type')->where('customer_id',$customer->id)->get()->toArray();

        return view('admin.customer.print.wedding_checklist', compact('customer','services'));
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
