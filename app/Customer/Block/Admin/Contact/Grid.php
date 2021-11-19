<?php
namespace App\Customer\Block\Admin\Contact;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['customer_id', 'first_name', 'last_name', 'email', 'telephone', 'role_id'];

    protected $adminRoute = 'admin.customer.contact';

    public function getInstance()
    {
        return new \App\Customer\Model\Contact();
    }

    protected function _beforeRender()
    {
        $this->addColumn('customer_id', 'Customer', 'select', true, new \App\Customer\Model\Source\Customers());
        $this->addColumn('first_name', 'First Name');
        $this->addColumn('last_name', 'Last Name');
        $this->addColumn('email', 'Email');
        $this->addColumn('telephone', 'Phone Number');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Customer - Contacts';
    }

}