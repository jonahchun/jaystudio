<?php

namespace App\WeddingSchedule\Http\Controllers\Admin\Ceremony;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected $_entity = 'Setting';

    protected function _init(Request $request)
    {
        $gridBlockClass = '\App\WeddingSchedule\Block\Admin\Ceremony\\' . $this->_entity . '\Grid';
        $formBlockClass = '\App\WeddingSchedule\Block\Admin\Ceremony\\' . $this->_entity . '\Form';
        $entityClass    = '\App\WeddingSchedule\Model\Ceremony\\' . $this->_entity;

        $this->gridBlock   = new $gridBlockClass($request);
        $this->formBlock   = new $formBlockClass();
        $this->entity      = new $entityClass();
        $this->entityTitle = 'Wedding Schedule - Ceremony ' . $this->_entity;
        $this->adminRoute  = 'admin.wedding.schedule.ceremony.' . strtolower($this->_entity);
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title'       => 'required|string|max:255',
            'identifier'  => 'required|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
        ]);
    }

}