<?php
namespace App\Notification\Block\Admin;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['customer_id','form_type'];

    protected $adminRoute = 'admin.notification';

    public function getInstance()
    {
        return new \App\Notification\Model\Notification();
    }

    protected function _beforeRender()
    {
        $this->addColumn('customer_id', 'Customer', 'select', false, \App\Customer\Model\Source\Customers::getInstance());
        $this->addColumn('form_type', 'Form Name');
        $this->addColumn('id', 'Notification Details','select', false, \App\Notification\Model\Source\Notifications::getInstance());
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Notifications';
    }

}
