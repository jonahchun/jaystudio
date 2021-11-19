<?php
namespace App\Album\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AcrylicImagesController extends VintageCoverController
{

    protected $_entity = 'AcrylicImage';

    protected function _init(Request $request)
    {
        parent::_init($request);
        $this->entityTitle = 'Album - Acrylic Images';
        $this->adminRoute  = 'admin.album.acrylic-images';
        return $this;
    }

}
