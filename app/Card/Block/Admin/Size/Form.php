<?php
namespace App\Card\Block\Admin\Size;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.card.size';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'title', 'Title', 'text', ['required' => true]);
        $this->addField('general', 'card_type', 'Card Type', 'select', [
            'required' => true,
            'source'   => \App\Card\Model\Source\Type::class,
        ]);
        $this->addField('general', 'sort_order', 'Sort Order', 'text', ['required' => false]);
        return parent::_beforeRender();
    }

}