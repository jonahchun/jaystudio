<?php
namespace App\Customer\Block\Admin\Contact\Role;

class Form extends \App\Core\Block\Admin\BaseForm
{

    protected $adminRoute = 'admin.customer.contact.role';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'title', 'Title', 'text', ['required' => true]);
        $this->addField('general', 'sort_order', 'Sort Order', 'text', ['required' => false]);

        return parent::_beforeRender();
    }

}
