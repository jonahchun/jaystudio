<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Services\Model\Source\Status;

class CinematographyController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index()
    {
    	$old_links = Auth::user()->links()->with('services')->get()->toArray();
    	
    	$links = [];

    	foreach ($old_links as $link_key => $link_value) {
    		if($link_value['services']['status'] == Status::COMPLETE){
	    		$links[] = $link_value; 
    		}
    	}
        
        return view('customer.wedding.cinematography',compact('links'));
    }
}