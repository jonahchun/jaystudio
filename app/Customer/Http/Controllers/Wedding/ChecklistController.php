<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

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

            if($data['button_type'] == "back"){
                $redirectBack = intval($data['current_step']) + 1 <= 7;
                $data['current_step'] = min(intval($data['current_step']) - 1, 6);
            }elseif($data['button_type'] == "gotostep"){
                $redirectBack = true;
                $data['current_step'] = $data['go_step'];
            }else{
                $redirectBack = intval($data['current_step']) + 1 <= 6;
                $data['current_step'] = min(intval($data['current_step']) + 1, 6);
            }
            
            Auth::user()->wedding_checklist->fill($data)->save();
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
            Alert::addError($e->getMessage());
        }
        return $redirectBack ? back() : redirect()->route('customer.wedding.info');
    }

}
