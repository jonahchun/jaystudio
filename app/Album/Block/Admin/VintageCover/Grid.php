<?php
namespace App\Album\Block\Admin\VintageCover;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'sort_order'];

    protected $adminRoute = 'admin.album.vintage-cover';

    public function getInstance()
    {
        return new \App\Album\Model\VintageCover();
    }

    protected function _beforeRender()
    {
        $this->addColumn('thumbnail', 'Thumbnail', 'image');
        $this->addColumn('title', 'Title');
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Album - Vintage Covers';
    }

}