<?php
namespace App\WeddingSchedule\Block\Admin\Ceremony\Setting;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'identifier', 'sort_order'];

    protected $adminRoute = 'admin.wedding.schedule.ceremony.setting';

    public function getInstance()
    {
        return new \App\WeddingSchedule\Model\Ceremony\Setting();
    }

    protected function _beforeRender()
    {
        $this->addColumn('title', 'Title');
        $this->addColumn('identifier', 'Identifier');
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Wedding Schedule - Ceremony Settings';
    }

}