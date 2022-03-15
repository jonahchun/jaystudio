<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Customer\Model\Wedding\Checklist;
use App\Notification\Model\Notification;

class ChecklistController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index()
    {
        if(!Auth::user()->wedding_checklist) {
            Auth::user()->wedding_checklist()->create([
                'preparation'      => '{}',
                'ceremony'         => '{}',
                'portrait_session' => '{}',
                'reception'        => '{}',
                'music'            => 0,
                'vendors'          => '{}',
                'current_step'     => 0,
                'comment'          => '',
            ]);
            Auth::user()->load('wedding_checklist');
        }

        return view('customer.wedding.checklist', \App\WeddingChecklist\Model\ChecklistEntities::getEntities());
    }

    public function save(Request $request)
    {
        try {
            $data = $request->all();
            $oldDetailValue = Auth::user()->wedding_checklist;
            if(Auth::user()->wedding_checklist){
                $oldDetailValue = Checklist::find(Auth::user()->wedding_checklist->id);
            }
            $notifData['form_type'] = Notification::FORM_TYPE_3;
            $notifData['customer_id'] = Auth::user()->id;

            $redirectBack = intval($data['current_step']) + 1 <= 6;
            $data['current_step'] = min(intval($data['current_step']) + 1, 6);
            Auth::user()->wedding_checklist->fill($data)->save();

            //add Notification for edit
            $this->editFormNotification($data,$notifData,$oldDetailValue);

            $initially_complete = Auth::user()->wedding_checklist->initially_complete;
            if($data['is_final_step'] == 1 && $initially_complete == 0){
                Auth::user()->wedding_checklist->update(['initially_complete'=>1]);
                 //add Notification
                 $notifData['form_type'] = Notification::FORM_TYPE_3;
                 $notifData['customer_type'] = Notification::NEW_CUSTOMER_TYPE;
                 $notifData['customer_id'] = Auth::user()->id;

                 Auth::user()->notifications()->create($notifData);
            }

        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
            Alert::addError($e->getMessage());
        }
        return $redirectBack ? back() : redirect()->route('customer.wedding.info');
    }

    public function editFormNotification($data,$notifData,$oldDetailValue){

        if($data['is_final_step'] == 0){
            $getOldValue = $oldDetailValue;
            $newData = $fieldData = [];

            if(isset($data['preparation'])){
                $newData['preparation'] = $data['preparation'];
                $fieldData['field_data'] =  $data["field_data"];
            }

            if(count($newData) > 0){
                $changedField = 0;
                foreach($newData as $newDataKey => $newDataVal){
                    $oldData = $getOldValue[$newDataKey];
                    if(count($oldData) > 0){
                        foreach($oldData as $oldDataKey => $oldDataVal){
                            if(array_key_exists($oldDataKey,$newDataVal)){
                                $getOldVal = is_array($oldDataVal)?$oldDataVal['value']:$oldDataVal;
                                $getNewVal = is_array($newDataVal[$oldDataKey])?$newDataVal[$oldDataKey]['value']:$newDataVal[$oldDataKey];
                                if($getOldVal != $getNewVal){
                                    $changedField = 1;
                                }
                            }else{
                                $changedField = 1;
                            }
                        }
                    }
                }
                echo ($changedField);exit;
            }
        }
    }
}
