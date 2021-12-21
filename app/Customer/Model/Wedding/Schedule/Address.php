<?php

namespace App\Customer\Model\Wedding\Schedule;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table = 'customer_wedding_schedule_address';

    protected $fillable = ['schedule_id', 'type', 'name', 'address_line_1', 'address_line_2', 'country', 'state', 'city', 'zip','hair_makeup_name','hair_makeup_address_line_1','hair_makeup_address_line_2','hair_makeup_country','hair_makeup_state','hair_makeup_city','hair_makeup_zip'];

}