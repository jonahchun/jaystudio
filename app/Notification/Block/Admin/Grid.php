<?php
namespace App\Notification\Block\Admin;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['id'];

    protected $adminRoute = 'admin.notification';

    public function getInstance()
    {
        return new \App\Notification\Model\Notification();
    }

    protected function _beforeRender()
    {
        $this->addColumn('id', 'ID');
        $this->addColumn('customer_id', 'Customer', 'select', false, \App\Customer\Model\Source\Customers::getInstance());
        $this->addColumn('form_type', 'Notification');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Notifications';
    }

}
