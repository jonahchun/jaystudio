<?php
namespace App\Customer\Block\Admin\Contact;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.customer.contact';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'customer_id', 'Customer', 'select', [
            'required' => true,
            'source'   => \App\Customer\Model\Source\Customers::class
        ]);
        $this->addField('general', 'photo', 'Photo', 'image', [
            'publicValue' => $this->getInstance()->getAttributeUrl('photo'),
        ]);
        $this->addField('general', 'first_name', 'First Name', 'text', ['required' => true]);
        $this->addField('general', 'last_name', 'Last Name', 'text', ['required' => true]);
        $this->addField('general', 'role_id', 'Role', 'select', [
            'required' => true,
            'source'   => \App\Customer\Model\Source\ContactRoles::class
        ]);
        $this->addField('general', 'email', 'Email', 'email', ['required' => true]);
        $this->addField('general', 'telephone', 'Phone Number', 'text', ['required' => true]);
        $this->addField('general', 'receive_emails', 'Receive Reminders?', 'select', [
            'required' => true,
            'source'   => \App\Core\Model\Source\Yesno::class
        ]);
        return parent::_beforeRender();
    }

}