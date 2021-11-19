<?php
namespace App\Card\Block\Admin\Template;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'card_type', 'side_type', 'layout_type', 'format', 'images_count', 'sort_order'];

    protected $adminRoute = 'admin.card.template';

    public function getInstance()
    {
        return new \App\Card\Model\Template();
    }

    protected function _beforeRender()
    {
        $this->addColumn('title', 'Title');
        $this->addColumn('image', 'Image', 'image', false);
        $this->addColumn('card_type', 'Card Type', 'select', true, new \App\Card\Model\Source\Type());
        $this->addColumn('side_type', 'Side Type', 'select', true, new \App\Card\Model\Source\SideType());
        $this->addColumn('layout_type', 'Layout Type', 'select', true, new \App\Card\Model\Source\LayoutType());
        $this->addColumn('format', 'Format', 'select', true, new \App\Card\Model\Source\Format());
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Card - Templates';
    }

}