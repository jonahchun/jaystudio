<?php
namespace App\Core\Block\Admin\Question;

class Form extends \App\Core\Block\Admin\BaseForm
{

    protected $adminRoute = 'admin.questions';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'question', 'Question', 'text', ['required' => true]);
        $this->addField('general', 'form_step', 'Form Step', 'select', [
            'required' => true,
            'source'   => \App\Core\Model\Source\FormStep::class
        ]);
        $this->addField('general', 'sort_order', 'Sort Order', 'text', ['required' => false]);
        return parent::_beforeRender();
    }

}
