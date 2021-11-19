<?php
namespace App\Core\Block\Admin\PickupLocation;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'address', 'telephone', 'sort_order'];

    protected $adminRoute = 'admin.pickup-location';

    public function getInstance()
    {
        return new \App\Core\Model\PickupLocation();
    }

    protected function _beforeRender()
    {
        $this->addColumn('title', 'Title');
        $this->addColumn('address', 'Address');
        $this->addColumn('telephone', 'Telephone');
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Pickup Locations';
    }

}