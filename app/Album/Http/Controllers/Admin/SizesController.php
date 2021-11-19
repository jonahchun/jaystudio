<?php
namespace App\Album\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizesController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected $_entity = 'Size';

    protected function _init(Request $request)
    {
        $gridBlockClass = '\App\Album\Block\Admin\\' . $this->_entity . '\Grid';
        $formBlockClass = '\App\Album\Block\Admin\\' . $this->_entity . '\Form';
        $entityClass    = '\App\Album\Model\\' . $this->_entity;

        $this->gridBlock   = new $gridBlockClass($request);
        $this->formBlock   = new $formBlockClass();
        $this->entity      = new $entityClass();
        $this->entityTitle = 'Album - ' . $this->_entity;
        $this->adminRoute  = 'admin.album.' . strtolower($this->_entity);
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, $this->_getValidationRules());
    }

    protected function _getValidationRules()
    {
        return [
            'title'      => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
