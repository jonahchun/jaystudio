<?php

namespace App\WeddingSchedule\Http\Controllers\Admin\Preparation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\WeddingSchedule\Block\Admin\Preparation\Setting\Grid($request);
        $this->formBlock   = new \App\WeddingSchedule\Block\Admin\Preparation\Setting\Form();
        $this->entity      = new \App\WeddingSchedule\Model\Preparation\Setting();
        $this->entityTitle = 'Wedding Schedule - Preparation Setting';
        $this->adminRoute  = 'admin.wedding.schedule.preparation.setting';
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