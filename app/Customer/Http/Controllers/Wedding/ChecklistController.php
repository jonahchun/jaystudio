<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
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
            $redirectBack = intval($data['current_step']) + 1 <= 6;
            $data['current_step'] = min(intval($data['current_step']) + 1, 6);
            Auth::user()->wedding_checklist->fill($data)->save();

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

}
