<?php

namespace App\Customer\Http\Controllers\Wedding;

class InfoController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index()
    {
        return view('customer.wedding.info');
    }

}
