<?php
namespace App\WeddingChecklist\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PreparationController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected $_entity = 'Preparation';

    protected function _init(Request $request)
    {
        $gridBlockClass = '\App\WeddingChecklist\Block\Admin\\' . $this->_entity . '\Grid';
        $formBlockClass = '\App\WeddingChecklist\Block\Admin\\' . $this->_entity . '\Form';
        $entityClass    = '\App\WeddingChecklist\Model\\' . $this->_entity;

        $this->gridBlock   = new $gridBlockClass($request);
        $this->formBlock   = new $formBlockClass();
        $this->entity      = new $entityClass();
        $this->entityTitle = 'Wedding Checklist - ' . $this->_entity;
        $this->adminRoute  = 'admin.wedding.checklist.' . strtolower($this->_entity);
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title'       => 'required|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
            'has_details' => 'nullable|integer|min:0|max:1',
        ]);
    }
}
