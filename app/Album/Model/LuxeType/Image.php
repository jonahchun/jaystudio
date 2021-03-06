<?php
namespace App\Album\Model\LuxeType;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{

    const MEDIA_PATH = 'album-luxe-type' . DIRECTORY_SEPARATOR;

    protected $table = 'album_luxe_type_images';

    protected $fillable = ['album_luxe_type_id', 'image', 'sort_order'];

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if($key == 'image' && !empty($value['file']) && $value['file'] instanceof \Illuminate\Http\UploadedFile) {
                $value = $this->_uploadFile($value['file']);
                $attributes[$key] = $value;
            }
        }
        return parent::fill($attributes);
    }

    public function getAttributeUrl($key)
    {
        $value = $this->getAttribute($key);
        return $value ? Storage::url(static::MEDIA_PATH . $value) : false;
    }

    protected function _uploadFile($file)
    {
        $path = 'public' . DIRECTORY_SEPARATOR . static::MEDIA_PATH;
        $fileName = $file->getClientOriginalName();
        $path .= substr($fileName, 0, 1) . DIRECTORY_SEPARATOR . substr($fileName, 1, 1) . DIRECTORY_SEPARATOR;
        if(Storage::disk('local')->exists($path . $fileName)) {
            $iterator = 1;
            while(Storage::disk('local')->exists($path . $fileName)) {
                $fileName = str_replace(
                    '.' . $file->getClientOriginalExtension(),
                    $iterator++ . '.' . $file->getClientOriginalExtension(),
                    $file->getClientOriginalName()
                );
            }
        }

        $file->storeAs($path, $fileName);
        return substr($fileName, 0, 1) . DIRECTORY_SEPARATOR . substr($fileName, 1, 1) . DIRECTORY_SEPARATOR . $fileName;
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['image_url'] = $this->getAttributeUrl('image');
        return $data;
    }

}