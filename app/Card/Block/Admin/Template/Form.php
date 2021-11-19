<?php
namespace App\Card\Block\Admin\Template;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.card.template';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'title', 'Title', 'text', ['required' => true]);
        $this->addField('general', 'image', 'Image', 'image', ['required' => true]);
        $this->addField('general', 'card_type', 'Card Type', 'select', [
            'required' => true,
            'source'   => \App\Card\Model\Source\Type::class,
        ]);
        $this->addField('general', 'side_type', 'Side Type', 'select', [
            'required' => true,
            'source'   => \App\Card\Model\Source\SideType::class,
        ]);
        $this->addField('general', 'layout_type', 'Layout Type', 'select', [
            'required' => true,
            'source'   => \App\Card\Model\Source\LayoutType::class,
        ]);
        $this->addField('general', 'format', 'Format', 'select', [
            'required' => true,
            'source'   => \App\Card\Model\Source\Format::class,
        ]);
        $this->addField('general', 'images_count', 'Images Count', 'text', ['required' => true]);
        $this->addField('general', 'sort_order', 'Sort Order', 'text', ['required' => false]);
        return parent::_beforeRender();
    }

}