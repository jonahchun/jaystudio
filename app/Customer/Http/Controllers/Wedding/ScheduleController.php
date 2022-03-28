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

            if($data['button_type'] == "back"){
                $redirectBack = intval($data['current_step']) + 1 <= 6;
                $data['current_step'] = min(intval($data['current_step']) - 1, 5);
            }elseif($data['button_type'] == "gotostep"){
                $redirectBack = true;
                $data['current_step'] = $data['go_step'];
            }else{
                $redirectBack = intval($data['current_step']) + 1 <= 5;
                $data['current_step'] = min(intval($data['current_step']) + 1, 5);
            }
            if($data['button_type'] == "back"){
                $notifData['form_steps'] = $data['current_step'] + 2;

            }elseif($data['button_type'] == "gotostep"){
                $notifData['form_steps'] = $data['go_prev_step'] + 1;

            }else{
                $notifData['form_steps'] = ($data['is_final_step'] == 1 ? $data['current_step'] + 1: $data['current_step']);

            }
            // dd($notifData);
            if($notifData['form_steps'] == 6){
                $oldDetailValue['schedule'] = Schedule::find(Auth::user()->wedding_schedule->id);
            }
            Auth::user()->wedding_schedule->fill($data)->save();
            $initially_complete = Auth::user()->wedding_schedule->initially_complete;

            //add Notification for edit
            if($initially_complete === '' || $initially_complete === 1){
                $this->editFormNotification($data,$notifData,$oldDetailValue);
            }
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
        unset($data['button_type']);
        unset($data['go_step']);
        unset($data['go_prev_step']);
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

            $fieldData['portrait_session_location'] = key_exists('portrait_session_location',$newCeremonyVal['field_data'])?$newCeremonyVal['field_data']['portrait_session_location']: [];
            $fieldData['portrait_session'] = array_diff_key($newCeremonyVal['field_data'], array_flip(["portrait_session_location"]));

            $newData['portrait_session_location'] = key_exists('portrait_session_location',$newCeremonyVal)?$newCeremonyVal['portrait_session_location']:[];
            $newData['portrait_session'] = array_diff_key($newCeremonyVal, array_flip(["portrait_session_location", "field_data"]));

            if(count($fieldData['portrait_session_location']) == 0){
                $fieldData['portrait_session_location'][0]['address'] = [];
                $newData['portrait_session_location'][0]['address'] = [];
            }
        }
        if($notifData['form_steps'] == 6){
            $fieldData['schedule'] = $data['field_data'];
            $newData['schedule'] = array_diff_key($data, array_flip(["field_data","_token","current_step","is_final_step"]));
        }

        if(count($newData) > 0){
            $arrayValFields = ['ceremony_traditions','details'];
            $notifData['customer_type'] = Notification::OLD_CUSTOMER_TYPE;
            // $notifData['form_steps'] = ($data['is_final_step'] == 1)?($data['current_step'] + 1):$data['current_step'];

            foreach($newData as $newDataKey => $newDataVal){

                if($newDataKey == 'portrait_session_location' && isset($data['portrait_session'])){

                    $newFillableData = $newDataVal;
                    if(count($newDataVal)>0){
                        foreach($newDataVal as $portraitKey => $portraitVal){
                            foreach($portraitVal as $portraitLocKey => $portraitLocVal){

                                if($portraitLocKey == 'address' ){
                                    if($portraitKey == 0){
                                        //For dynamic portrait session locations
                                        $locationListResult = $this->compareSessionLocationList($newFillableData, $getOldValue[$newDataKey]);

                                        if($locationListResult['isChanged'] == 1){
                                            $notifData['old_data'] = $locationListResult['oldData'];
                                            $notifData['new_data'] = $locationListResult['newData'];
                                            $notifData['field_name'] = json_decode($fieldData[$newDataKey][$portraitKey][$portraitLocKey],true)['val'];
                                            $notifData['field_type'] = json_decode($fieldData[$newDataKey][$portraitKey][$portraitLocKey],true)['type'];
                                            \App\Customer\Helper\Data::saveNotification($notifData);
                                        }
                                    }
                                }else{
                                    if($portraitLocVal != ''){
                                        $getOldAddressData = (count($getOldValue[$newDataKey]) == 0 )?'':$getOldValue[$newDataKey][$portraitKey][$portraitLocKey];
                                        $oldDataVal = trim($getOldAddressData);
                                        $newDataVal = trim($portraitLocVal);

                                        if(strcasecmp($newDataVal,$oldDataVal) != 0 ){
                                            $fieldInfo = json_decode($fieldData[$newDataKey][$portraitKey][$portraitLocKey], true);

                                            $notifData['old_data'] = $getOldAddressData;
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
            }
        }
    }
    public function compareSessionLocationList($newAddressData,$getOldAddressData){
        $newData = $oldData = $compareArr1 = $compareArr2 = [];

        if(count($newAddressData)>0){
            foreach($newAddressData as $newAddressDataKey => $newAddressDataVal){
                $newData['address_line_1'][$newAddressDataKey] = (key_exists('address_line_1',$newAddressDataVal['address']))?$newAddressDataVal['address']['address_line_1']:'';
                $newData['address_line_2'][$newAddressDataKey] = (key_exists('address_line_2',$newAddressDataVal['address']))?$newAddressDataVal['address']['address_line_2']:'';
                $newData['city'][$newAddressDataKey] = (key_exists('city',$newAddressDataVal['address']))?$newAddressDataVal['address']['city']:'';
                $newData['state'][$newAddressDataKey] = (key_exists('state',$newAddressDataVal['address']))?$newAddressDataVal['address']['state']:'';
                $newData['zip'][$newAddressDataKey] = (key_exists('zip',$newAddressDataVal['address']))?$newAddressDataVal['address']['zip']:'';
            }
        }

        if(count($getOldAddressData) > 0 ){
            foreach($getOldAddressData as $getOldAddressDataKey => $getOldAddressDataVal){
                $oldData['address_line_1'][$getOldAddressDataKey] = $getOldAddressDataVal['address']['address_line_1'];
                $oldData['address_line_2'][$getOldAddressDataKey] = $getOldAddressDataVal['address']['address_line_2'];
                $oldData['city'][$getOldAddressDataKey] = $getOldAddressDataVal['address']['city'];
                $oldData['state'][$getOldAddressDataKey] = $getOldAddressDataVal['address']['state'];
                $oldData['zip'][$getOldAddressDataKey] = $getOldAddressDataVal['address']['zip'];
            }
        }else{
            $oldData['address_line_1'][] = '';
            $oldData['address_line_2'][] = '';
            $oldData['city'][] = '';
            $oldData['state'][] = '';
            $oldData['zip'][] = '';
        }

        if(count($newData['address_line_1']) > count($oldData['address_line_1'])){
            $compareArr1 = $newData;
            $compareArr2 = $oldData;
        }else{
            $compareArr1 = $oldData;
            $compareArr2 = $newData;
        }

        $isChanged = 0;
        $result = [];
        foreach($newData as $key => $val){
            $compareCount = count(array_diff($compareArr1[$key],$compareArr2[$key]));
            if($compareCount > 0){
                $isChanged = 1;
            }
        }
        $result['newData'] = json_encode($newData);
        $result['oldData'] = json_encode($oldData);
        $result['isChanged'] = $isChanged;
        return $result;
    }
}
