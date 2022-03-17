<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

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
            // dd($data);
            if(isset($data['portrait_session'])){
                $data['portrait_session']['when'] = json_encode($data['portrait_session']['when']);
            }
            // dd(Auth::user()->wedding_schedule->first_newlywed_address);
            // dd($data);
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

            if($data['button_type'] == "back"){
                $redirectBack = intval($data['current_step']) + 1 <= 6;
                $data['current_step'] = min(intval($data['current_step']) - 1, 5);
            }else{
                $redirectBack = intval($data['current_step']) + 1 <= 5;
                $data['current_step'] = min(intval($data['current_step']) + 1, 5);
            }
            
            Auth::user()->wedding_schedule->fill($data)->save();
            return $redirectBack ? back() : redirect()->route('customer.wedding.info');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
            return back();
        }
    }
}
