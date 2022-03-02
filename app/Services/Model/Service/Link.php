<?php
namespace App\Services\Model\Service;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Link extends Model
{

    protected $table = 'service_links';

    protected $fillable = ['customer_id','service_id', 'link', 'type'];

    public function services()
    {
        return $this->hasOne(\App\Services\Model\Service::class, 'id','service_id');
    }
}

?>