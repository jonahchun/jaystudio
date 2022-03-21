<?php

namespace App\Notification\Model\Source;

use App\Notification\Model\Notification;

class Notifications extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        $notifDetail = [];

        foreach(Notification::all() as $notification) {
            if($notification->customer_type == \App\Notification\Model\Notification::NEW_CUSTOMER_TYPE){
                $notifDetail[$notification->id] = \App\Notification\Model\Notification::NOTIF_MSG_1;
            }else{
                $stepForType1 = \App\Notification\Model\Notification::STEP_FOR_TYPE_1;
                $stepForType2 = \App\Notification\Model\Notification::STEP_FOR_TYPE_2;
                $stepForType3 = \App\Notification\Model\Notification::STEP_FOR_TYPE_3;

                $step = [];
                if($notification->form_type == \App\Notification\Model\Notification::FORM_TYPE_1){
                    $step =  $stepForType1;
                }else if($notification->form_type == \App\Notification\Model\Notification::FORM_TYPE_2){
                    $step =  $stepForType2;
                }else if($notification->form_type == \App\Notification\Model\Notification::FORM_TYPE_3){
                    $step =  $stepForType3;
                }
                $fieldName = json_decode($notification->field_name,true);

                if($fieldName == ''){
                    $fieldName = $notification->field_name;
                }else{
                    $fieldName = (is_array($fieldName)?implode(",",$fieldName):$fieldName);
                }
                $notifDetail[$notification->id] = $step[$notification->form_steps - 1].' | '.(is_array($fieldName)?implode(",",$fieldName):$fieldName);
            }
        }

        return $notifDetail;
    }


}
