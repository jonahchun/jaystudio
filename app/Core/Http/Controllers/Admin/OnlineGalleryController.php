<?php
namespace App\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OnlineGalleryController{

	public function index(){
		return view('admin.online-gallery.link');
	}

	public function save(Request $request){
		dd($request->all());
	}
}