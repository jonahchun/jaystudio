<?php

namespace App\Customer\Model\Wedding\Schedule;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table = 'customer_wedding_schedule_address';

    protected $fillable = ['schedule_id', 'type', 'name', 'address_line_1', 'address_line_2', 'country', 'state', 'city', 'zip'];

}