<?php
namespace App\Customer\Block\Admin\Contact\Role;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title', 'sort_order'];

    protected $adminRoute = 'admin.customer.contact.role';

    public function getInstance()
    {
        return new \App\Customer\Model\Contact\Role();
    }

    protected function _beforeRender()
    {
        $this->addColumn('title', 'Title');
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Customer - Contact Roles';
    }

}