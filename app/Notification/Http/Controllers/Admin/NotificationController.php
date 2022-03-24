<?php

namespace App\Notification\Http\Controllers\Admin;

use App\Notification\Model\Notification;
use App\WeddingChecklist\Model\Vendor;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class NotificationController extends \WFN\Admin\Http\Controllers\Crud\Controller
{
    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Notification\Block\Admin\Grid($request);
        $this->formBlock   = new \App\Notification\Block\Admin\Form();
        $this->entity      = new \App\Notification\Model\Notification();
        $this->entityTitle = 'Notifications';
        $this->adminRoute  = 'admin.notification';
        return $this;
    }
    public function new()
    {
        if($customerId = request('customer_id')) {
            $this->entity->customer_id = $customerId;
        }
        return parent::new();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'customer_id' => 'required|exists:customer,id',
        ]);
    }


}
