<?php

namespace App\Customer\Http\Controllers;
use App\Customer\Model\Customer;

class IndexController extends \WFN\Customer\Http\Controllers\Controller
{

    public function dashboard()
    {
        return view('customer.dashboard');
    }
    public function downloadInsuranceFile($id)
    {
    	$customer = Customer::find($id);

    	$file_path = '';
    	if(!empty($customer->insurance_certificate_file)){
    		$file_path = storage_path().'/app/public/insurance_certificate/'.$customer->insurance_certificate_file;

    		return \Response::download($file_path);
    	}
    }

    public function info()
    {
        return view('customer.account.info');
    }

}
