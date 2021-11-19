<?php
namespace App\Album\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VintageCoverController extends SizesController
{

    protected $_entity = 'VintageCover';

    protected function _init(Request $request)
    {
        parent::_init($request);
        $this->entityTitle = 'Album - Vintage Cover';
        $this->adminRoute  = 'admin.album.vintage-cover';
        return $this;
    }

    protected function _getValidationRules()
    {
        $rules = parent::_getValidationRules();
        $rules['thumbnail'] = 'required';
        return $rules;
    }
}
