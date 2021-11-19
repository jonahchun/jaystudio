<?php
namespace App\Services\Model\Service;

use Illuminate\Database\Eloquent\Model;
use App\Core\Model\Traits\HasUploads;
use App\Services\Model\Source\EditRequest\Status;

class EditRequest extends Model
{

    use HasUploads;

    const MEDIA_PATH = 'service' . DIRECTORY_SEPARATOR . 'edit-requests' . DIRECTORY_SEPARATOR;
    
    protected $fillable = ['service_id', 'status', 'detail', 'comment', 'file'];

    protected $table = 'service_edit_requests';

    protected $mediaFields = ['file'];

    protected $casts = [
        'detail' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(\App\Services\Model\Service::class);
    }

    public function getStatusLabelAttribute($value = null)
    {
        return Status::getInstance()->getOptionLabel($this->status);
    }

    public function getCustomerIdAttribute($value = null)
    {
        return $this->service->customer->id;
    }

}