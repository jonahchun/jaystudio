<?php
namespace App\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Core\Model\OnlineGalleryLink;

class OnlineGalleryController{

	public function index(){
		$link_count = OnlineGalleryLink::count();

		$link = '';
		$id = '';
		
		if($link_count > 0){
			$links = OnlineGalleryLink::first();
			$link = $links->url; 
			$id = $links->id; 
		}
		
		return view('admin.online-gallery.link',compact('link','id'));
	}

	public function save(Request $request){
		$link = OnlineGalleryLink::updateOrCreate(['id'=>$request->id]);
		$link->url = $request->url;
		$link->save();
		
		return redirect()->route('admin.gallery-link');
	}
}