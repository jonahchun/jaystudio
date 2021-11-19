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
            $redirectBack = intval($data['current_step']) + 1 <= 5;
            $data['current_step'] = min(intval($data['current_step']) + 1, 5);
            Auth::user()->wedding_schedule->fill($data)->save();
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
        }
        return $redirectBack ? back() : redirect()->route('customer.wedding.info');
    }
}
