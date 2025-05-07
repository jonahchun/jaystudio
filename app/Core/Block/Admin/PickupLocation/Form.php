<?php
namespace App\Core\Block\Admin\PickupLocation;

class Form extends \App\Core\Block\Admin\BaseForm
{

    protected $adminRoute = 'admin.pickup-location';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'title', 'Title', 'text', ['required' => true]);
        $this->addField('general', 'address', 'Address', 'textarea', ['required' => true]);
        $this->addField('general', 'telephone', 'Telephone');
        $this->addField('general', 'working_hours', 'Working Hours', 'textarea');
        $this->addField('general', 'sort_order', 'Sort Order', 'text', ['required' => false]);
        return parent::_beforeRender();
    }

}
