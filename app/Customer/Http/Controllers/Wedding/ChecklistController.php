<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Customer\Model\Wedding\Checklist;
use App\Customer\Model\Wedding\Checklist\SongsList;
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
            $oldDetailValue['oldChecklistData'] = Auth::user()->wedding_checklist;
            $oldDetailValue['oldSongList'] = '';
            if(Auth::user()->wedding_checklist){
                $oldDetailValue['oldChecklistData'] = Checklist::find(Auth::user()->wedding_checklist->id);
                $oldDetailValue['oldSongList'] = SongsList::where('checklist_id',Auth::user()->wedding_checklist->id)->get();
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

        $getOldValue = $oldDetailValue['oldChecklistData'];
        $notifData['customer_type'] = Notification::OLD_CUSTOMER_TYPE;
        $notifData['form_steps'] = ($data['is_final_step'] == 1)?($data['current_step'] + 1):$data['current_step'];

        if($data['is_final_step'] == 0){
            $newData = $fieldData = [];

            if(isset($data['preparation'])){
                $newData['preparation'] = $data['preparation'];
                $fieldData['field_data'] =  $data["field_data"];
            }else if(isset($data['ceremony'])){
                $newData['ceremony'] = $data['ceremony'];
                $fieldData['field_data'] =  $data["field_data"];
            }else if(isset($data['portrait_session'])){
                $newData['portrait_session'] = $data['portrait_session'];
                $fieldData['field_data'] =  $data["field_data"];
            }else if(isset($data['reception'])){
                $newData['reception'] = $data['reception'];
                $fieldData['field_data'] =  $data["field_data"];
            }else if(isset($data['music'])){
                $newData['music'] = array_diff_key($data, array_flip(["_token", "field_data","current_step","is_final_step"]));
                $fieldData['field_data'] =  $data["field_data"];
            }else if(isset($data['vendors'])){
                $newData['vendors'] = $data['vendors'];
                $fieldData['field_data'] =  $data["field_data"];
            }

            if(count($newData) > 0){
                $changedField = 0;
                $maxEleArray = [];
                foreach($newData as $newDataKey => $newDataVal){
                    $oldDataArray = $newDataArray = [];
                    if($newDataKey == 'music'){
                        foreach($newDataVal as $newDataMusicKey => $newDataMusicVal){
                            $fieldInfo = $fieldData['field_data'][$newDataMusicKey];
                            if(!is_array($newDataMusicVal)){
                                if(strcasecmp($getOldValue[$newDataMusicKey],$newDataMusicVal) != 0 ){
                                    $notifData['old_data'] = $getOldValue[$newDataMusicKey];
                                    $notifData['new_data'] = $newDataMusicVal;
                                    $notifData['field_name'] = json_decode($fieldInfo)->val;
                                    $notifData['field_type'] = json_decode($fieldInfo)->type;
                                    \App\Customer\Helper\Data::saveNotification($notifData);
                                }
                            }else{//for song list
                                $songListResult = $this->compareSongList($newDataMusicVal,$oldDetailValue['oldSongList']);
                                if($songListResult['isChanged'] == 1){
                                    $notifData['old_data'] = $songListResult['oldData'];
                                    $notifData['new_data'] = $songListResult['newData'];
                                    $notifData['field_name'] = json_decode($fieldInfo['songs_list'])->val;
                                    $notifData['field_type'] = json_decode($fieldInfo['songs_list'])->type;
                                    \App\Customer\Helper\Data::saveNotification($notifData);
                                }
                            }
                        }
                    }else{
                        $oldData = $getOldValue[$newDataKey];
                        if(count($oldData) > 0){
                            foreach($oldData as $oldDataKey => $oldDataVal){
                                if($newDataKey == 'vendors'){
                                    foreach($oldDataVal as $vendKey => $vendVal){
                                        $oldDataArray[$oldDataKey][$vendKey] = $vendVal;
                                    }
                                }else{
                                    $oldDataArray[$oldDataKey] = is_array($oldDataVal)?$oldDataVal['value']:$oldDataVal;
                                }
                            }
                        }
                        if(count($newDataVal) > 0){
                            foreach($newDataVal as $newDataValKey => $newDataValVal){
                                if($newDataKey == 'vendors'){
                                    foreach($newDataValVal as $vendKey => $vendVal){
                                        $newDataArray[$newDataValKey][$vendKey] = $vendVal;
                                    }
                                }else{
                                   $newDataArray[$newDataValKey] = is_array($newDataValVal)?$newDataValVal['value']:$newDataValVal;
                                }
                            }
                        }
                    }
                }if(count($oldDataArray) > 0 && count($newDataArray) > 0){
                    $maxEleArray = array_unique (array_merge (array_keys($oldDataArray), array_keys($newDataArray)));
                    if(count($maxEleArray) > 0){
                        $notiNewDataArray = $notiOldDataArray = $fieldNameArray = [];
                        foreach($maxEleArray as $maxEleArrayVal){
                            if($maxEleArrayVal == 'comment'){
                                if(strcasecmp($oldDataArray[$maxEleArrayVal],$newDataArray[$maxEleArrayVal]) != 0 ){
                                    $notifData['old_data'] = $oldDataArray[$maxEleArrayVal];
                                    $notifData['new_data'] = $newDataArray[$maxEleArrayVal];
                                    $notifData['field_name'] = json_decode($fieldData['field_data'][$maxEleArrayVal])->val;
                                    $notifData['field_type'] = json_decode($fieldData['field_data'][$maxEleArrayVal])->type;
                                    \App\Customer\Helper\Data::saveNotification($notifData);
                                }
                            }else{
                                if($newDataKey == 'vendors'){
                                    $vendorFieldNameArr = [];
                                    foreach($newDataArray[$maxEleArrayVal] as $vendKey => $vendVal){
                                        if(strcasecmp($vendVal,$oldDataArray[$maxEleArrayVal][$vendKey]) != 0 ){
                                            $changedField = 1;
                                            $notiOldDataArray[$maxEleArrayVal][$vendKey] = $oldDataArray[$maxEleArrayVal][$vendKey];
                                            $notiNewDataArray[$maxEleArrayVal][$vendKey] = $vendVal;
                                            $vendorFieldNameArr[$vendKey] =  json_decode($fieldData['field_data'][$maxEleArrayVal][$vendKey])->val;
                                            $notifData['field_type'] = json_decode($fieldData['field_data'][$maxEleArrayVal][$vendKey])->type;
                                            $fieldNameArray[$maxEleArrayVal] = implode(" , ",$vendorFieldNameArr);
                                        }
                                    }
                                }else{
                                    if(!array_key_exists($maxEleArrayVal,$oldDataArray) || !array_key_exists($maxEleArrayVal,$newDataArray)){
                                        $changedField = 1;
                                        $notiOldDataArray[$maxEleArrayVal] = array_key_exists($maxEleArrayVal,$oldDataArray)?$oldDataArray[$maxEleArrayVal]:'no';
                                        $notiNewDataArray[$maxEleArrayVal] = array_key_exists($maxEleArrayVal,$newDataArray)?$newDataArray[$maxEleArrayVal]:'no';
                                        $fieldNameArray[$maxEleArrayVal] = json_decode($fieldData['field_data'][$maxEleArrayVal]['value'])->val;
                                        $notifData['field_type'] = json_decode($fieldData['field_data'][$maxEleArrayVal]['value'])->type;
                                   }
                                }
                            }
                        }
                    }
                }
                if($changedField == 1){
                    $notifData['old_data'] = json_encode($notiOldDataArray);
                    $notifData['new_data'] = json_encode($notiNewDataArray);
                    $notifData['field_name'] = json_encode($fieldNameArray);
                    \App\Customer\Helper\Data::saveNotification($notifData);
                }
            }
        }else{
            $oldCommentValue = $getOldValue->comment;
            $oldFileValue = $getOldValue->file;
            if(trim($oldCommentValue) !== trim($data['comment'])){
                $notifData['customer_type'] = Notification::OLD_CUSTOMER_TYPE;
                $notifData['field_name'] = Notification::COMMENT_FIELD;
                $notifData['field_type'] = Notification::COMMENT_FIELD_TYPE;
                $notifData['old_data'] = $oldCommentValue;
                $notifData['new_data'] = $data['comment'];
                \App\Customer\Helper\Data::saveNotification($notifData);
            }
            if(trim($oldFileValue) !== trim($data['file'])){
                $notifData['customer_type'] = Notification::OLD_CUSTOMER_TYPE;
                $notifData['field_name'] = Notification::FILE_FIELD;
                $notifData['field_type'] = Notification::FILE_FIELD_TYPE;
                $notifData['old_data'] = $oldFileValue;
                $notifData['new_data'] = Auth::user()->newlywed_detail->file;
                \App\Customer\Helper\Data::saveNotification($notifData);
            }
        }
    }

    public function compareSongList($songNewData,$getOldSongData){
        $newData = $oldData = $compareArr1 = $compareArr2 = [];

        if(count($songNewData)>0){
            foreach($songNewData as $songNewDataKey => $songNewDataVal){
                $newData['name'][$songNewDataKey] = $songNewDataVal['song_name'];
                $newData['type'][$songNewDataKey] = key_exists('type',$songNewDataVal)?$songNewDataVal['type']:'';
            }
        }
        if(count($getOldSongData) > 0 ){
            foreach($getOldSongData as $getOldSongDataKey => $getOldSongDataVal){
                $oldData['name'][$getOldSongDataKey] = $getOldSongDataVal['song_name'];
                $oldData['type'][$getOldSongDataKey] = $getOldSongDataVal['type'];
            }
        }else{
            $oldData['name'][] = '';
            $oldData['type'][] = '';
        }

        if(count($newData['name']) > count($oldData['name'])){
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
