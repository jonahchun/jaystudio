<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

class CinematographyController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index()
    {
    	$links = Auth::user()->links()->with('services')->get();
    	
        return view('customer.wedding.cinematography',compact('links'));
    }
}