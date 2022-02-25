<?php
namespace App\Services\Model\Service;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{

	const MEDIA_PATH = 'teaser_photo' . DIRECTORY_SEPARATOR;
    
    protected $table = 'service_teaser_photos';

    protected $fillable = ['customer_id','service_id', 'image'];

    public function services()
    {
        return $this->hasOne(\App\Services\Model\Service::class, 'id','service_id');
    }

    public function fill(array $attributes)
    {
            	// dd($attributes);
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

    public function imageName($key){
        $value = $this->getAttribute($key);
        if($key == 'image'){
            $name = explode("\\",$value);  
            return $name[count($name)-1];
        }
        return '';
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

        // dd(substr($fileName, 0, 1) . DIRECTORY_SEPARATOR . substr($fileName, 1, 1) . DIRECTORY_SEPARATOR . $fileName);
        $file->storeAs($path, $fileName);
        return substr($fileName, 0, 1) . DIRECTORY_SEPARATOR . substr($fileName, 1, 1) . DIRECTORY_SEPARATOR . $fileName;
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['image_url'] = $this->getAttributeUrl('image');
        $data['image_name'] = $this->imageName('image');
        return $data;
    }
}

?>