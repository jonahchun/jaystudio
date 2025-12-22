<?php

namespace App\Customer\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use WFN\Customer\Model\Customer\Detail;

class Address extends Detail
{
    use SoftDeletes;

    const MEDIA_PATH = 'address' . DIRECTORY_SEPARATOR;

    protected $table = 'customer_address';

}
