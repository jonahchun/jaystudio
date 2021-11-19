<?php
namespace App\Album\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtDecoPatternController extends VintageCoverController
{

    protected $_entity = 'ArtDecoPattern';

    protected function _init(Request $request)
    {
        parent::_init($request);
        $this->entityTitle = 'Album - Art Deco Pattern';
        $this->adminRoute  = 'admin.album.art-deco-pattern';
        return $this;
    }

}
