<?php
namespace App\WeddingChecklist\Block\Admin\Preparation;

class Grid extends
{

    protected $filterableFields = ['title', 'sort_order', 'has_details'];

    protected $adminRoute = 'admin.wedding.checklist.preparation';

    public function getInstance()
    {
        return new \App\WeddingChecklist\Model\Preparation();
    }

    protected function _beforeRender()
    {
        $this->addColumn('title', 'Title');
        $this->addColumn('sort_order', 'Sort Order');
        $this->addColumn('has_details', 'Has Details', 'select', true, new \App\Core\Model\Source\Yesno());
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Wedding Checklist - Preparations';
    }

}
