<?php
namespace App\Card\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Card\Model\Source\Type;
use App\Card\Model\Source\LayoutType;
use App\Card\Model\Source\Format;
use App\Card\Model\Source\SideType;

class TemplateController extends SizesController
{

    protected $_entity = 'Template';

    protected function _getValidationRules()
    {
        $sizeTypes   = SideType::getInstance()->getOptions();
        $cardTypes   = Type::getInstance()->getOptions();
        $layoutTypes = LayoutType::getInstance()->getOptions();
        $formats     = Format::getInstance()->getOptions();
        return [
            'title'        => 'required|string|max:255',
            'card_type'    => 'required|in:' . implode(',', array_keys($cardTypes)),
            'image'        => 'required',
            'side_type'    => 'required|in:' . implode(',', array_keys($sizeTypes)),
            'layout_type'  => 'required|in:' . implode(',', array_keys($layoutTypes)),
            'format'       => 'required|in:' . implode(',', array_keys($formats)),
            'images_count' => 'required|integer|min:0',
            'sort_order'   => 'nullable|integer|min:0',
        ];
    }
}
