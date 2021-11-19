<?php
namespace App\Album\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlackMatteCoverController extends VintageCoverController
{

    protected $_entity = 'BlackMatteCover';

    protected function _init(Request $request)
    {
        parent::_init($request);
        $this->entityTitle = 'Album - Black Matte Cover';
        $this->adminRoute  = 'admin.album.black-matte-cover';
        return $this;
    }

}
