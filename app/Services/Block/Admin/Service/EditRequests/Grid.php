<?php
namespace App\Services\Block\Admin\Service\EditRequests;

use App\Services\Model\Source\EditRequest\Status;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['customer_id', 'status'];

    protected $adminRoute = 'admin.customer.service.edit_request';

    public function getInstance()
    {
        return new \App\Services\Model\Service\EditRequest();
    }

    protected function _beforeRender()
    {
        $this->addColumn('customer_id', 'Customer', 'select', true, new \App\Customer\Model\Source\Customers());
        $this->addColumn('status', 'Status', 'select', true, Status::getInstance());
        $this->addColumn('comment', 'Comment', 'text');
        $this->addColumn('created_at', 'Initiated', 'date');
        
        $this->addAction('Edit', $this->adminRoute . '.edit', 'edit');

        return $this;
    }

    protected function _getCollection()
    {
        $query = $this->getInstance()
            ->newQuery();

        if(isset($this->request['status']) && $this->request['status'] !== '') {
            $query->where('status', $this->request['status']);
        }

        if(isset($this->request['customer_id']) && $this->request['customer_id'] !== '') {
            $customerId = $this->request['customer_id'];
            $query->whereHas('service', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            });
        }
        
        $query->orderBy($this->getOrderBy(), $this->getDirection());

        return $query;
    }

    public function getTitle()
    {
        return 'Service - Edit Requests';
    }

}