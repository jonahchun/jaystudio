<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Customer\Model\Newlywed\Detail;
use App\Notification\Model\Notification;

class DetailsController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index()
    {
        if(!Auth::user()->newlywed_detail) {
            Auth::user()->newlywed_detail()->create([
                'question_answers' => '{}',
                'current_step'     => 0,
                'comment'          => '',
            ]);
            Auth::user()->load('newlywed_detail');
        }
        $questions = [];
        foreach(\App\Core\Model\Question::orderBy('form_step', 'ASC')->orderBy('sort_order', 'asc')->get() as $index => $question) {
            if(empty($questions[$question->form_step - 1])) {
                $questions[$question->form_step - 1] = [];
            }
            $question->number = $index + 1;
            $questions[$question->form_step - 1][] = $question;
        };
        return view('customer.wedding.details', compact('questions'));
    }

    public function save(Request $request)
    {
        try {
            $data = $request->all();
            $oldDetailValue = Auth::user()->newlywed_detail;
            // dd($data);
            $initially_complete = Auth::user()->newlywed_detail->initially_complete;
            if(Auth::user()->newlywed_detail){
                $oldDetailValue = Detail::find(Auth::user()->newlywed_detail->id);
            }
            $notifData['form_type'] = Notification::FORM_TYPE_1;
            $notifData['customer_id'] = Auth::user()->id;

            if($data['button_type'] == "back"){
                $redirectBack = intval($data['current_step']) + 1 <= 4;
                $data['current_step'] = min(intval($data['current_step']) - 1, 3);
            }elseif($data['button_type'] == "gotostep"){
                $redirectBack = true;
                $data['current_step'] = $data['go_step'];
            }else{
                $redirectBack = intval($data['current_step']) + 1 <= 3;
                $data['current_step'] = min(intval($data['current_step']) + 1, 3);
            }

            Auth::user()->newlywed_detail->fill($data)->save();
            //add Notification for edit
            if($initially_complete === '' || $initially_complete === 1){
                $this->editFormNotification($data,$notifData,$oldDetailValue);
            }
            $answerExist = $this->checkAnswerExist();

            if($answerExist == 1 && $data['is_final_step'] == 1 && $initially_complete == 0){
                Auth::user()->newlywed_detail->update(['initially_complete'=>1]);

                //add Notification for initial form
                $notifData['customer_type'] = Notification::NEW_CUSTOMER_TYPE;
                \App\Customer\Helper\Data::saveNotification($notifData);
            }
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
            Alert::addError($e->getMessage());
        }
        return $redirectBack ? back() : redirect()->route('customer.wedding.info');
    }

    public function checkAnswerExist(){
        $valueExist = 0;
        $questionAnswers = Auth::user()->newlywed_detail->question_answers;
        $comment = Auth::user()->newlywed_detail->comment;
        $file = Auth::user()->newlywed_detail->file;
        if(count($questionAnswers)> 0 ){
            foreach($questionAnswers as $val){
                if($val != null){
                    $valueExist = 1;
                }
            }
        }
        if($comment != '' || $file != ''){
            $valueExist = 1;
        }
        return $valueExist;
    }

    public function editFormNotification($data,$notifData,$oldDetailValue){
        if($data['button_type'] == "back"){
            $notifData['form_steps'] = $data['current_step'] + 2;

        }elseif($data['button_type'] == "gotostep"){
            $notifData['form_steps'] = $data['go_prev_step'] + 1;

        }else{
            $notifData['form_steps'] = ($data['is_final_step'] == 1 ? $data['current_step'] + 1: $data['current_step']);

        }
        // dd($data);
        // dd($notifData);
        // $notifData['form_steps'] = ($data['is_final_step'] == 1)?($data['current_step'] + 1):$data['current_step'];
        if($notifData['form_steps'] != 4){
            $getOldValue = $oldDetailValue->question_answers;
            $newValue = $data['question_answers'];
            $form_fields = json_decode($data['form_fields'], true);
            $form_field_type = json_decode($data['form_field_type'], true);

            if(count($newValue) > 0){
                $i = 0;
                foreach($newValue as $key => $val){
                    if(trim($val) !== trim($getOldValue[$key])){
                        $notifData['customer_type'] = Notification::OLD_CUSTOMER_TYPE;
                        $notifData['field_name'] = strtolower($form_fields[$i]);
                        $notifData['field_type'] = strtolower($form_field_type[$i]);
                        $notifData['old_data'] = $getOldValue[$key];
                        $notifData['new_data'] = $val;
                        \App\Customer\Helper\Data::saveNotification($notifData);
                    }
                    $i++;
                }
            }
        }else{
            $oldCommentValue = $oldDetailValue->comment;
            $oldFileValue = $oldDetailValue->file;

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
}
