<?php

namespace App\Customer\Model\Contact;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = 'customer_contact_roles';

    protected $fillable = ['title', 'sort_order'];

}