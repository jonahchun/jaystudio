<?php
namespace App\Customer\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class DownloadController extends Controller
{

    public function printFileDownload($file)
    {
        $fileUrl = 'storage/'.base64_decode($file);
        return response()->download($fileUrl);
    }

}
