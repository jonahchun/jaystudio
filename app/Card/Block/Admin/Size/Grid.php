<?php
namespace App\Card\Block\Admin\Size;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'card_type', 'sort_order'];

    protected $adminRoute = 'admin.card.size';

    public function getInstance()
    {
        return new \App\Card\Model\Size();
    }

    protected function _beforeRender()
    {
        $this->addColumn('title', 'Title');
        $this->addColumn('card_type', 'Card Type', 'select', true, new \App\Card\Model\Source\Type());
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Card - Sizes';
    }

}