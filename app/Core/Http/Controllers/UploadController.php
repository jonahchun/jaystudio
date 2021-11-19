<?php

namespace App\Core\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends \WFN\Customer\Http\Controllers\Controller
{

    public function upload(Request $request)
    {
        if(!$request->input('file') || !$request->input('file') instanceof \Illuminate\Http\UploadedFile) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $path = 'public' . DIRECTORY_SEPARATOR . 'tmp';
            $file->storeAs($path, $fileName);
            return ['success' => true, 'file' => 'tmp/' . $fileName];
        }
        return ['success' => false];
    }

}