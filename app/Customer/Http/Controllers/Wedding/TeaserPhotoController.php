<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Model\Source\Status;
use Chumper\Zipper\Facades\Zipper;

class TeaserPhotoController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index()
    {
        $photos_data = Auth::user()->teaser_photos()->with('services')->get()->toArray();

        $photos = [];

    	foreach ($photos_data as $photo_key => $photo_value) {
    		if($photo_value['services']['status'] == Status::PROCESSING){
	    		$photos[] = $photo_value;
    		}
    	}

        return view('customer.teaser_photo',compact('photos'));
    }

    public function zipFileDownload($file,$form){
        $formName = $form;
        $fileList= base64_decode($file);
        $fileListArray = explode('|',$fileList);
        $dowaloadFile = [];
        if(count($fileListArray)>0){
            foreach($fileListArray as $file){
                $fileUrl = explode('/',$file);
                if($fileUrl[0] == 'tmp'){
                    $file_url = 'storage/'.$file;
                }else{
                    if($formName == 'teaser_photo'){
                        $folder_name = 'teaser_photo';
                    }
                    $file_url = ltrim($file,'/');
                }
                $dowaloadFile[] =  $file_url;
            }
        }
        $headers = ["Content-Type"=>"application/zip"];
        $zipName = $folder_name.'-'.time().'.zip';
        $zipPath = 'downloaded-zip/'.$folder_name.'/'.$zipName;


        Zipper::make(public_path($zipPath))->add($dowaloadFile)->close();
        return response()->download(public_path($zipPath),$zipName,$headers);
    }
}
