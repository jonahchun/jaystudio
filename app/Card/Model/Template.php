<?php
namespace App\Card\Model;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Template extends Model
{

    const MEDIA_PATH = 'card' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR;

    protected $table = 'card_templates';

    protected $fillable = ['title', 'card_type', 'image', 'side_type', 'layout_type', 'format', 'images_count', 'sort_order'];

    protected $mediaFields = ['image'];

    public function getAttributeUrl($key)
    {
        $value = $this->getAttribute($key);
        return $value ? Storage::url(static::MEDIA_PATH . $value) : false;
    }

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if(in_array($key, $this->mediaFields) && !empty($value['file']) && $value['file'] instanceof \Illuminate\Http\UploadedFile) {
                $value = $this->_uploadFile($value['file']);
                $attributes[$key] = $value;
            }
        }
        return parent::fill($attributes);
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
        return substr($fileName, 0, 1) . '/' . substr($fileName, 1, 1) . '/' . $fileName;
    }

    public function toArray()
    {
        $data = parent::toArray();
        foreach ($this->mediaFields as $key) {
            $data[$key . '_url'] = $this->getAttributeUrl($key);
        }
        return $data;

    }

}