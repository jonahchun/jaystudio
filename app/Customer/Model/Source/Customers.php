<?php

namespace App\Customer\Model\Source;

use App\Customer\Model\Customer;

class Customers extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        $options = [];
        foreach(Customer::all() as $customer) {
            $options[$customer->id] = $customer->newlywed_names . ' (' . $customer->account_id . ')';
        }
        return $options;
    }

}