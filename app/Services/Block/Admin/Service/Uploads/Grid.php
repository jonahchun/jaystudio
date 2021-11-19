<?php
namespace App\Services\Block\Admin\Service\Uploads;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['status'];

    protected $adminRoute = 'admin.customer.service.uploads';

    public function getInstance()
    {
        return new \App\Services\Model\Service\Upload();
    }

    protected function _beforeRender()
    {
        $this->addColumn('id', 'ID', 'text', true);
        $this->addColumn('status', 'Status', 'select', true, new \App\Services\Model\Source\Upload\Status());
        $this->addColumn('created_at', 'Initiated', 'date');
        parent::_beforeRender();
        $this->buttons = [];
        return $this;
    }

    public function getTitle()
    {
        return 'Service - Uploads';
    }

}