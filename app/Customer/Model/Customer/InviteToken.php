<?php

namespace App\Customer\Model\Customer;

use Illuminate\Database\Eloquent\Model;

class InviteToken extends Model
{

    protected $table = 'customer_invite_token';

    protected $fillable = ['customer_id', 'token'];

    public function customer()
    {
        return $this->belongsTo(\Customer::class);
    }
}