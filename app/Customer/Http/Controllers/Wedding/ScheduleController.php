<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
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
            // dd(Auth::user()->wedding_schedule->first_newlywed_address);
           //dd($data);

            $notifData['form_type'] = Notification::FORM_TYPE_2;
            $notifData['customer_id'] = Auth::user()->id;

            if(isset($data['first_newlywed_preparation'])){
                if(isset($data['first_newlywed_preparation']['hair_makeup']) && $data['first_newlywed_preparation']['hair_makeup'] == 1){
                    $data['first_newlywed_preparation']['address']['hair_makeup_name']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_address_line_1']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_address_line_2']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_city']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_state']='';
                    $data['first_newlywed_preparation']['address']['hair_makeup_zip']='';
                }
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
            }

            $redirectBack = intval($data['current_step']) + 1 <= 5;
            $data['current_step'] = min(intval($data['current_step']) + 1, 5);
            Auth::user()->wedding_schedule->fill($data)->save();

            //add Notification for edit
            $this->editFormNotification($data,$notifData);

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

    public function editFormNotification($data,$notifData){

    }
}
