<?php
namespace App\Services\Model\Service;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{

    protected $fillable = ['service_id', 'status', 'is_customer_notified', 'comment'];

    protected $table = 'service_status_history';

    public function service()
    {
        return $this->belongsTo(\App\Services\Model\Service::class);
    }    
}