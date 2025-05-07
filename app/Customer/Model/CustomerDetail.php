<?php

namespace App\Model;

use App\Core\Model\Traits\HasUploads;

class CustomerDetail extends \WFN\Customer\Model\Customer\Detail
{
    public function __construct(array $attributes = [])
    {

        return parent::__construct($attributes);
    }


}
