<?php
namespace App\Services\Model\Service;

use Illuminate\Database\Eloquent\Model;
use Storage;

class OnlineGallery extends Model
{

    protected $table = 'service_online_gallery';

    protected $fillable = ['customer_id','service_id', 'gallery_name', 'access_code','password'];

    public function services()
    {
        return $this->hasOne(\App\Services\Model\Service::class, 'id','service_id');
    }
}

?>