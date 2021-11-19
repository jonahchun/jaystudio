<?php
namespace App\Card\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Card\Model\Source\Type;

class SizesController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected $_entity = 'Size';

    protected function _init(Request $request)
    {
        $gridBlockClass = '\App\Card\Block\Admin\\' . $this->_entity . '\Grid';
        $formBlockClass = '\App\Card\Block\Admin\\' . $this->_entity . '\Form';
        $entityClass    = '\App\Card\Model\\' . $this->_entity;

        $this->gridBlock   = new $gridBlockClass($request);
        $this->formBlock   = new $formBlockClass();
        $this->entity      = new $entityClass();
        $this->entityTitle = 'Card - ' . $this->_entity;
        $this->adminRoute  = 'admin.card.' . strtolower($this->_entity);
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
            'card_type'  => 'required|in:' . Type::TYC . ',' . Type::STD,
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
