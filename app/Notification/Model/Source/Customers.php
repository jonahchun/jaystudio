<?php

namespace App\Notification\Model\Source;

use App\Customer\Model\Customer;

class Customers extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        $options = [];
        $acoountName = '';
        foreach(Customer::all() as $customer) {


            if($customer->first_newlywed->first_name == '' && $customer->second_newlywed->first_name == ''){
                $acoountName = '-';
            }else{
                $acoountName = $customer->first_newlywed->first_name.' & '.$customer->second_newlywed->first_name;
            }
            $options[$customer->id] = $acoountName;//$customer->newlywed_names;
        }
        return $options;
    }

}
