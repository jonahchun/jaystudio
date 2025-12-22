<?php

namespace App\Services\Model\Service;

use App\Customer\Model\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class OnlineGallery extends Model
{
    use SoftDeletes;

    protected $table = 'service_online_gallery';

    protected $fillable = ['customer_id', 'service_id', 'gallery_name', 'access_code', 'password'];

    public function services()
    {
        return $this->hasOne(\App\Services\Model\Service::class, 'id', 'service_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

}

?>
