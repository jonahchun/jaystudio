<?php
namespace App\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PickupLocationController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Core\Block\Admin\PickupLocation\Grid($request);
        $this->formBlock   = new \App\Core\Block\Admin\PickupLocation\Form();
        $this->entity      = new \App\Core\Model\PickupLocation();
        $this->entityTitle = 'Pickup Location';
        $this->adminRoute  = 'admin.pickup-location';
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title'      => 'required|string|max:255',
            'address'    => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }
}
