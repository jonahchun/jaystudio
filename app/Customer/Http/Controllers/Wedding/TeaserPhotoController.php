<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Model\Source\Status;

class TeaserPhotoController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index()
    {
        $photos_data = Auth::user()->teaser_photos()->with('services')->get()->toArray();

        $photos = [];

    	foreach ($photos_data as $photo_key => $photo_value) {
    		if($photo_value['services']['status'] == Status::COMPLETE){
	    		$photos[] = $photo_value; 
    		}
    	}
        
        return view('customer.teaser_photo',compact('photos'));
    }
}