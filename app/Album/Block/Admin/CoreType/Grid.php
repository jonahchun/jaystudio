<?php
namespace App\Album\Block\Admin\CoreType;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'photos_count', 'sort_order'];

    protected $adminRoute = 'admin.album.core-type';

    public function getInstance()
    {
        return new \App\Album\Model\CoreType();
    }

    protected function _beforeRender()
    {
        $this->addColumn('title', 'Title');
        $this->addColumn('photos_count', 'Photos Count');
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Album - Core Types';
    }

}