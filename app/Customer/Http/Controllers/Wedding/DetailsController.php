<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

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
            $redirectBack = intval($data['current_step']) + 1 <= 3;
            $data['current_step'] = min(intval($data['current_step']) + 1, 3);
            Auth::user()->newlywed_detail->fill($data)->save();
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
            Alert::addError($e->getMessage());
        }
        return $redirectBack ? back() : redirect()->route('customer.wedding.info');
    }

}
