<?php

namespace App\Customer\Model\Source;

use App\Customer\Model\Contact\Role;

class ContactRoles extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        $options = [];
        foreach(Role::orderBy('sort_order', 'asc')->get() as $contactRole) {
            $options[$contactRole->id] = $contactRole->title;
        }
        return $options;
    }

}