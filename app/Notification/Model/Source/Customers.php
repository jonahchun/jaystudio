<?php

namespace App\Notification\Model\Source;

use App\Customer\Model\Customer;

class Customers extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        $options = [];
        foreach(Customer::all() as $customer) {
            $options[$customer->id] = $customer->newlywed_names;
        }
        return $options;
    }

}
