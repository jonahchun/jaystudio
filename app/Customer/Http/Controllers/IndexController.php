<?php

namespace App\Customer\Http\Controllers;

class IndexController extends \WFN\Customer\Http\Controllers\Controller
{

    public function dashboard()
    {
        return view('customer.dashboard');
    }

    public function info()
    {
        return view('customer.account.info');
    }

}
