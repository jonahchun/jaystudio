<?php
namespace App\Album\Block\Admin\Size;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'sort_order'];

    protected $adminRoute = 'admin.album.size';

    public function getInstance()
    {
        return new \App\Album\Model\Size();
    }

    protected function _beforeRender()
    {
        $this->addColumn('title', 'Title');
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Album - Sizes';
    }

}