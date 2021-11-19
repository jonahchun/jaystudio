<?php
namespace App\WeddingChecklist\Block\Admin\Vendor;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'sort_order', 'is_required'];

    protected $adminRoute = 'admin.wedding.checklist.vendor';

    public function getInstance()
    {
        return new \App\WeddingChecklist\Model\Vendor();
    }

    protected function _beforeRender()
    {
        $this->addColumn('title', 'Title');
        $this->addColumn('sort_order', 'Sort Order');
        $this->addColumn('is_required', 'Is Required', 'select', true, \App\Core\Model\Source\Yesno::class);
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Wedding Checklist - Vendors';
    }

}