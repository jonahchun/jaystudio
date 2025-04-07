<?php
namespace App\WeddingChecklist\Block\Admin\Preparation;

class Form extends \App\Core\Block\Admin\BaseForm
{

    protected $adminRoute = 'admin.wedding.checklist.preparation';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'title', 'Title', 'text', ['required' => true]);
        $this->addField('general', 'sort_order', 'Sort Order', 'text', ['required' => false]);
        $this->addField('general', 'has_details', 'Has Details', 'select', [
            'required' => false,
            'source'   => \App\Core\Model\Source\Yesno::class,
        ]);
        return parent::_beforeRender();
    }

}
