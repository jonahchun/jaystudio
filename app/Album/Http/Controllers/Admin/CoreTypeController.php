<?php
namespace App\Album\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoreTypeController extends SizesController
{

    protected $_entity = 'CoreType';

    protected function _init(Request $request)
    {
        parent::_init($request);
        $this->entityTitle = 'Album - Core Type';
        $this->adminRoute  = 'admin.album.core-type';
        return $this;
    }

    protected function _getValidationRules()
    {
        $rules = parent::_getValidationRules();
        $rules['photos_count'] = 'required|integer|min:0';
        return $rules;
    }
}
