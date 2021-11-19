<?php
namespace App\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionsController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Core\Block\Admin\Question\Grid($request);
        $this->formBlock   = new \App\Core\Block\Admin\Question\Form();
        $this->entity      = new \App\Core\Model\Question();
        $this->entityTitle = 'Details about you - Question';
        $this->adminRoute  = 'admin.questions';
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'question'   => 'required|string|max:255',
            'form_step'  => 'required',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }
}
