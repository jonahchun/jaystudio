<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeaserPhotoController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index()
    {
        $photos = Auth::user()->teaser_photos()->get()->toArray();
        
        return view('customer.teaser_photo',compact('photos'));
    }
}