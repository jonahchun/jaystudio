<?php
namespace App\Album\Block\Admin\LuxeType;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'sort_order'];

    protected $adminRoute = 'admin.album.luxe-type';

    public function getInstance()
    {
        return new \App\Album\Model\LuxeType();
    }

    protected function _beforeRender()
    {
        $this->addColumn('image', 'Image', 'image');
        $this->addColumn('title', 'Title');
        $this->addColumn('sizes', 'Sizes', 'multiselect', false, new \App\Album\Model\Source\Sizes());
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Album - Luxe Types';
    }

}