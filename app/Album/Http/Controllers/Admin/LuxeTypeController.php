<?php
namespace App\Album\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LuxeTypeController extends SizesController
{

    protected $_entity = 'LuxeType';

    protected function _init(Request $request)
    {
        parent::_init($request);
        $this->entityTitle = 'Album - Luxe Type';
        $this->adminRoute  = 'admin.album.luxe-type';
        return $this;
    }

    protected function _getValidationRules()
    {
        $rules = parent::_getValidationRules();
        
        // TODO: Images validation

        return $rules;
    }
}
