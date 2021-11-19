<?php
namespace App\Services\Model\Service;

use Illuminate\Database\Eloquent\Model;
use App\Core\Model\Traits\HasUploads;
use App\Services\Model\Source\Upload\Status;

class Upload extends Model
{

    use HasUploads;

    const FILE_TITLE_LENGTH = 15;

    const MEDIA_PATH = 'service' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
    
    protected $fillable = ['service_id', 'file', 'url_link', 'status', 'comment'];

    protected $table = 'service_uploads';

    protected $mediaFields = ['file'];

    public function service()
    {
        return $this->belongsTo(\App\Services\Model\Service::class);
    }

    public function getFileTitleAttribute($value = null)
    {
        $value = trim($this->file ?: $this->url_link, '/');
        $value = explode('/', $value);
        $value = array_pop($value);
        return substr($value, 0, static::FILE_TITLE_LENGTH) . 
            (strlen($value) > static::FILE_TITLE_LENGTH ? '...' : '');
    }

    public function getFileUrlAttribute($value = null)
    {
        $value = $this->file ?: $this->url_link;
        return strpos($value, 'http') === false ? $this->getAttributeUrl('file') : $value;
    }

    public function getStatusLabelAttribute($value = null)
    {
        return Status::getInstance()->getOptionLabel($this->status);
    }

}