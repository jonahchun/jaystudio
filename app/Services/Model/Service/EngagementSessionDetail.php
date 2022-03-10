<?php
namespace App\Services\Model\Service;

use Illuminate\Database\Eloquent\Model;
use App\Core\Model\Traits\HasUploads;

class EngagementSessionDetail extends Model
{

    use HasUploads;

    const MEDIA_PATH = 'service' . DIRECTORY_SEPARATOR . 'engagement_session' . DIRECTORY_SEPARATOR;
    
    const TYPE = \App\Services\Model\Source\Type::ENGAGEMENT_SESSION;

    protected $fillable = ['service_id', 'upload', 'status', 'completion'];

    protected $dates = ['completion'];

    public function __construct(array $attributes = [])
    {
        $this->table = 'service_' . static::TYPE . '_detail';
        return parent::__construct($attributes);
    }

    public function delivery_location()
    {
        return $this->belongsTo(\App\Core\Model\PickupLocation::class);
    }
    
}