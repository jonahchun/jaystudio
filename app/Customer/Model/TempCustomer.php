<?php

namespace App\Customer\Model;

use Illuminate\Database\Eloquent\Model;

class TempCustomer extends Model
{

	protected $table = "temp_customer_detail";
    protected $fillable = [
        'id', 'customer_id', 'json'
    ];
}
?>
