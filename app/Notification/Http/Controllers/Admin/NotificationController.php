<?php

namespace App\Notification\Http\Controllers\Admin;

use App\Notification\Model\Notification;
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

    public function getNotification()
    {
        $result = [];
        $notification = [];
        $notificationId = [];
        $getNotif = Notification::where(['is_read'=>0])->orderBy('notifications.created_at','desc')->get();

        if(count($getNotif)>0){
            foreach($getNotif as $val){
                $customer = $val->customer;
                $cusName = $customer->first_newlywed->first_name.' & '.$customer->second_newlywed->first_name;
                $notification[] = $cusName.' '.Notification::NOTIF_MSG_1.' '.$val['form_type'].' form';
                $notificationId[] = $val->id;
            }
        }
        $result['notifCount'] = count($getNotif);
        $result['notification'] = $notification;
        $result['notificationId'] = $notificationId;
        return $result;
    }

    public function notificationFlagChange(Request $request){
        $notifId = $request['notifIds'];
        if(isset($notifId) && count($notifId) > 0){
            Notification::whereIn('id',$notifId)->update(['is_read'=>0]);
        }
    }

}
