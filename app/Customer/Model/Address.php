<?php

namespace App\Customer\Model;

use WFN\Customer\Model\Customer\Detail;

class Address extends Detail
{

    const MEDIA_PATH = 'address' . DIRECTORY_SEPARATOR;

    protected $table = 'customer_address';

}