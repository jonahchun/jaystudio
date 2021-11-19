<?php
namespace App\Album\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtDecoColorController extends VintageCoverController
{

    protected $_entity = 'ArtDecoColor';

    protected function _init(Request $request)
    {
        parent::_init($request);
        $this->entityTitle = 'Album - Art Deco Color';
        $this->adminRoute  = 'admin.album.art-deco-color';
        return $this;
    }

    protected function _getValidationRules()
    {
        $rules = parent::_getValidationRules();
        unset($rules['thumbnail']);
        return $rules;
    }

}
