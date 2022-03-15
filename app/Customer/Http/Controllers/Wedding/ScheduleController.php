<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Customer\Model\Source\Schedule\AddressType;
use App\Customer\Model\Wedding\Schedule;
use App\Customer\Model\Wedding\Schedule\Address;
use App\Customer\Model\Wedding\Schedule\Ceremony;
use App\Customer\Model\Wedding\Schedule\PortraitSession;
use App\Customer\Model\Wedding\Schedule\PortraitSession\PortraitSessionLocation;
use App\Customer\Model\Wedding\Schedule\Preparation;
use App\Customer\Model\Wedding\Schedule\Reception;
use App\Notification\Model\Notification;

class ScheduleController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index()
    {
        if(!Auth::user()->wedding_schedule) {
            Auth::user()->createWeddingSchedule();
        }
        return view('customer.wedding.schedule');
    }

    public function save(Request $request)
    {
        try {
            $data = $request->all();
            if(isset($data['portrait_session'])){
                $data['portrait_session']['when'] = json_encode($data['portrait_session']['when']);
            }
            //dd($data);

            $notifData['form_type'] = Notification::FORM_TYPE_2;
            $notifData['customer_id'] = Auth::user()->id;
            $oldDetailValue = [];

            if(isset($data['first_newlywed_preparation'])){
                if(isset($data['first_newlywed_preparation']['hair_makeup']) && $data['first_newlywed_preparation']['hair_makeup'] == 1){
                    $data['first_newlywed_preparation']['address']['hair_makeup_name']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_address_line_1']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_address_line_2']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_city']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_state']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_zip']='';
                }
                $oldDetailValue['address'] = Address::where(['schedule_id'=>Auth::user()->wedding_schedule->id,'type' => AddressType::FIRST_NEWLYWED_PREPARATION])->first();
                $oldDetailValue['preparation'] = Preparation::where(['schedule_id'=>Auth::user()->wedding_schedule->id,'type' => 'first'])->first();
            }
            if(isset($data['second_newlywed_preparation'])){
                if(isset($data['second_newlywed_preparation']['hair_makeup']) && $data['second_newlywed_preparation']['hair_makeup'] == 1){
                    $data['second_newlywed_preparation']['address']['hair_makeup_name']='';
                    $data['second_newlywed_preparation']['address']['hair_makeup_address_line_1']='';
                    $data['second_newlywed_preparation']['address']['hair_makeup_address_line_2']='';
                    $data['second_newlywed_preparation']['address']['hair_makeup_city']='';
                    $data['second_newlywed_preparation']['address']['hair_makeup_state']='';
                    $data['second_newlywed_preparation']['address']['hair_makeup_zip']='';
                }

                $oldDetailValue['address'] = Address::where(['schedule_id'=>Auth::user()->wedding_schedule->id,'type' => AddressType::SECOND_NEWLYWED_PREPARATION])->first();
                $oldDetailValue['preparation'] = Preparation::where(['schedule_id'=>Auth::user()->wedding_schedule->id,'type' => 'second'])->first();
            }
            if(isset($data['ceremony'])){
                $oldDetailValue['address'] = Address::where(['schedule_id'=>Auth::user()->wedding_schedule->id,'type' => AddressType::CEREMONY])->first();
                $oldDetailValue['ceremony'] = Ceremony::where(['schedule_id'=>Auth::user()->wedding_schedule->id])->first();
            }
            if(isset($data['reception'])){
                $oldDetailValue['address'] = Address::where(['schedule_id'=>Auth::user()->wedding_schedule->id,'type' => AddressType::RECEPTION])->first();
                $oldDetailValue['reception'] = Reception::where(['schedule_id'=>Auth::user()->wedding_schedule->id])->first();
            }
            if(isset($data['portrait_session'])){
                $oldDetailValue['portrait_session'] = PortraitSession::where(['schedule_id'=>Auth::user()->wedding_schedule->id])->first();
                $oldDetailValue['portrait_session_location'] = PortraitSessionLocation::where(['portrait_session_id'=>$oldDetailValue['portrait_session']->id])->get()->toArray();
            }
            if($data['is_final_step'] == 1){
                $oldDetailValue['schedule'] = Schedule::find(Auth::user()->wedding_schedule->id);
            }
            $redirectBack = intval($data['current_step']) + 1 <= 5;
            $data['current_step'] = min(intval($data['current_step']) + 1, 5);
            Auth::user()->wedding_schedule->fill($data)->save();

            //add Notification for edit
            $this->editFormNotification($data,$notifData,$oldDetailValue);

            $initially_complete = Auth::user()->wedding_schedule->initially_complete;
            if($data['is_final_step'] == 1 && $initially_complete == 0){
                Auth::user()->wedding_schedule->update(['initially_complete'=>1]);
                 //add Notification
                 $notifData['customer_type'] = Notification::NEW_CUSTOMER_TYPE;

                 Auth::user()->notifications()->create($notifData);
            }

            return $redirectBack ? back() : redirect()->route('customer.wedding.info');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
            return back();
        }
    }

    public function editFormNotification($data,$notifData,$oldDetailValue){
        $getOldValue = $oldDetailValue;
        $newData = $fieldData = [];
        if(isset($data['first_newlywed_preparation'])){
            $newFirstNewlywedPreValue = $data['first_newlywed_preparation'];
            $fieldData['address'] = $newFirstNewlywedPreValue['field_data']['address'];
            $fieldData['preparation'] = array_diff_key($newFirstNewlywedPreValue['field_data'], array_flip(["address", "field_data"]));
            $newData['address'] = $newFirstNewlywedPreValue['address'];
            $newData['preparation'] = array_diff_key($newFirstNewlywedPreValue, array_flip(["address", "field_data"]));
        }
        if(isset($data['second_newlywed_preparation'])){
            $newSecNewlywedPreValue = $data['second_newlywed_preparation'];
            $fieldData['address'] = $newSecNewlywedPreValue['field_data']['address'];
            $fieldData['preparation'] = array_diff_key($newSecNewlywedPreValue['field_data'], array_flip(["address", "field_data"]));
            $newData['address'] = $newSecNewlywedPreValue['address'];
            $newData['preparation'] = array_diff_key($newSecNewlywedPreValue, array_flip(["address", "field_data"]));
        }
        if(isset($data['ceremony'])){
            $newCeremonyVal = $data['ceremony'];
            $fieldData['address'] = $newCeremonyVal['field_data']['address'];
            $fieldData['ceremony'] = array_diff_key($newCeremonyVal['field_data'], array_flip(["address", "field_data"]));

            $newData['address'] = $newCeremonyVal['address'];
            $newData['ceremony'] = array_diff_key($newCeremonyVal, array_flip(["address", "field_data"]));

            $newData['ceremony']['ceremony_traditions'] = (key_exists('ceremony_traditions',$newData['ceremony']) && $newData['ceremony']['ceremony_traditions'] != '')?$newData['ceremony']['ceremony_traditions']:[];
            $newData['ceremony']['details'] = (key_exists('details',$newData['ceremony']) && $newData['ceremony'] != '')?$newData['ceremony']['details']:NULL;
        }
        if(isset($data['reception'])){
            $newCeremonyVal = $data['reception'];
            $fieldData['address'] = $newCeremonyVal['field_data']['address'];
            $fieldData['reception'] = array_diff_key($newCeremonyVal['field_data'], array_flip(["address", "field_data"]));

            $newData['address'] = $newCeremonyVal['address'];
            $newData['reception'] = array_diff_key($newCeremonyVal, array_flip(["address", "field_data"]));
        }
        if(isset($data['portrait_session'])){
            $newCeremonyVal = $data['portrait_session'];
            $fieldData['portrait_session_location'] = $newCeremonyVal['field_data']['portrait_session_location'];
            $fieldData['portrait_session'] = array_diff_key($newCeremonyVal['field_data'], array_flip(["portrait_session_location"]));

            $newData['portrait_session_location'] = $newCeremonyVal['portrait_session_location'];
            $newData['portrait_session'] = array_diff_key($newCeremonyVal, array_flip(["portrait_session_location", "field_data"]));
        }
        if($data['is_final_step'] == 1){
            $fieldData['schedule'] = $data['field_data'];
            $newData['schedule'] = array_diff_key($data, array_flip(["field_data","_token","current_step","is_final_step"]));
        }
        if(count($newData) > 0){
            $arrayValFields = ['ceremony_traditions','details'];
            $notifData['customer_type'] = Notification::OLD_CUSTOMER_TYPE;
            $notifData['form_steps'] = ($data['is_final_step'] == 1)?($data['current_step'] + 1):$data['current_step'];

            foreach($newData as $newDataKey => $newDataVal){
                if($newDataKey == 'portrait_session_location' && isset($data['portrait_session'])){
                    if(count($newDataVal)>0){
                        foreach($newDataVal as $portraitKey => $portraitVal){
                            foreach($portraitVal as $portraitLocKey => $portraitLocVal){
                                $getOldAdressData = $getOldValue[$newDataKey][$portraitKey][$portraitLocKey];
                                if($portraitLocKey == 'address'){
                                    foreach($portraitLocVal as $protraitAddKey => $protraitAddVal){
                                        if($protraitAddVal != '' && $protraitAddKey != 'portrait_session_location_id'){
                                            if($portraitVal[$portraitLocKey]['portrait_session_location_id'] == ''){
                                                $oldDataVal =  null;
                                            }else{
                                                $oldDataVal = trim($getOldAdressData[$protraitAddKey]);
                                            }

                                            $notifData['old_data'] = $oldDataVal;
                                            $newDataVal = trim($protraitAddVal);
                                            if(strcasecmp($newDataVal,$oldDataVal) != 0 ){
                                                $fieldInfo = json_decode($fieldData[$newDataKey][$portraitKey][$portraitLocKey][$protraitAddKey], true);
                                                $notifData['new_data'] = $newDataVal;
                                                $notifData['field_name'] = str_replace("_"," ",$fieldInfo['val']);
                                                $notifData['field_type'] = $fieldInfo['type'];
                                                \App\Customer\Helper\Data::saveNotification($notifData);
                                            }
                                        }
                                    }
                                }else{
                                    if($portraitLocVal != ''){
                                        $oldDataVal = trim($getOldAdressData);
                                        $newDataVal = trim($portraitLocVal);
                                        if(strcasecmp($newDataVal,$oldDataVal) != 0 ){
                                            $fieldInfo = json_decode($fieldData[$newDataKey][$portraitKey][$portraitLocKey], true);

                                            $notifData['old_data'] = $getOldAdressData;
                                            $notifData['new_data'] = $portraitLocVal;
                                            $notifData['field_name'] = str_replace("_"," ",$fieldInfo['val']);
                                            $notifData['field_type'] = $fieldInfo['type'];
                                            \App\Customer\Helper\Data::saveNotification($notifData);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }else{
                    foreach($newDataVal as $newKey => $newVal){
                        $isEdit = 0;
                        if(in_array($newKey,$arrayValFields)){
                            $oldDataVal = $getOldValue[$newDataKey][$newKey];
                            $newDataVal = $newVal;
                            sort($oldDataVal);
                            sort($newDataVal);

                            if (($oldDataVal) !== ($newDataVal)){
                                $isEdit = 1;
                                $fieldInfo = json_decode($fieldData[$newDataKey][$newKey], true);

                                $notifData['old_data'] = json_encode($getOldValue[$newDataKey][$newKey]);
                                $notifData['new_data'] = json_encode($newVal);
                                $notifData['field_name'] = str_replace("_"," ",$fieldInfo['val']);
                                $notifData['field_type'] = $fieldInfo['type'];
                            }
                        }else{
                            $oldDataVal = trim($getOldValue[$newDataKey][$newKey]);
                            $newDataVal = trim($newVal);
                            if($newKey == 'comment' || $newKey == 'file'){
                                $notifData['field_name'] = ($newKey == 'comment')?Notification::COMMENT_FIELD:Notification::FILE_FIELD;
                                $notifData['field_type'] = ($newKey == 'comment')?Notification::COMMENT_FIELD_TYPE:Notification::FILE_FIELD_TYPE;
                            }
                            else{
                                $notifData['field_name'] = '';
                                if(array_key_exists($newKey,$fieldData[$newDataKey])){
                                    $fieldInfo = json_decode($fieldData[$newDataKey][$newKey], true);
                                    $notifData['field_name'] = str_replace("_"," ",$fieldInfo['val']);
                                    $notifData['field_type'] = $fieldInfo['type'];
                                }
                            }
                            if(strcasecmp($newDataVal,$oldDataVal) != 0 ){
                                $isEdit = 1;
                                $notifData['old_data'] = $getOldValue[$newDataKey][$newKey];
                                $notifData['new_data'] = $newVal;
                            }
                        }
                        if($isEdit == 1){
                            \App\Customer\Helper\Data::saveNotification($notifData);
                        }
                    }
                }
            }//exit;
        }
    }
}
