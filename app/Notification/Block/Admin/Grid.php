<?php
namespace App\Notification\Block\Admin;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['customer_id','account_id','form_type'];

    protected $adminRoute = 'admin.notification';

    public function getInstance()
    {
        return new \App\Notification\Model\Notification();
    }

    protected function _beforeRender()
    {
        $this->addColumn('account_id','Account Id', 'text', true,'',['field'=>'customer_id','tableInstance'=>'Customer']);
        $this->addColumn('customer_id', 'Name', 'select', false, \App\Notification\Model\Source\Customers::getInstance());
        $this->addColumn('form_type', 'Form Name');
        $this->addColumn('id', 'Notification Details','select', false, \App\Notification\Model\Source\Notifications::getInstance());
        //parent::_beforeRender();
        //array_shift($this->buttons);
        return $this;
    }

    public function getTitle()
    {
        return 'Notifications';
    }

}