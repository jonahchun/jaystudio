<?php
namespace App\Services\Block\Admin\Service;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['type', 'customer_id', 'status'];

    protected $adminRoute = 'admin.customer.service';

    public function getInstance()
    {
        return new \App\Services\Model\Service();
    }

    protected function _beforeRender()
    {
        $this->addColumn('customer_id', 'Customer', 'select', true, new \App\Customer\Model\Source\Customers());
        $this->addColumn('type', 'Type', 'select', true, new \App\Services\Model\Source\Type());
        $this->addColumn('status', 'Status', 'select', true, new \App\Services\Model\Source\Status());
        $this->addColumn('created_at', 'Initiated', 'date');
        parent::_beforeRender();
        array_shift($this->buttons);
        return $this;
    }

    public function getTitle()
    {
        return 'Services';
    }

}