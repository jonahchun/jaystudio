<?php
namespace App\Album\Model;

use Illuminate\Database\Eloquent\Model;
use Storage;

class LuxeType extends Model
{

    const MEDIA_PATH = 'album' . DIRECTORY_SEPARATOR . 'collection' . DIRECTORY_SEPARATOR;

    protected $table = 'album_luxe_types';

    protected $fillable = ['title', 'image', 'sort_order'];

    protected $_sizes = [];

    protected $_images = [];

    public function sizeRelations()
    {
        return $this->hasMany(\App\Album\Model\LuxeTypeSizes::class, 'album_luxe_type_id');
    }

    public function images()
    {
        return $this->hasMany(\App\Album\Model\LuxeType\Image::class, 'album_luxe_type_id');
    }

    public function getAttribute($key)
    {
        if($key == 'sizes') {
            return $this->_getSizeIds();
        }
        return parent::getAttribute($key);
    }

    public function getAttributeUrl($key)
    {
        $value = $this->getAttribute($key);
        return $value ? Storage::url(static::MEDIA_PATH . $value) : false;
    }

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if($key == 'sizes') {
                $this->_sizes = $value;
            }

            if($key == 'images') {
                $this->_images = $value;
            }

            if($key == 'image' && !empty($value['file']) && $value['file'] instanceof \Illuminate\Http\UploadedFile) {
                $value = $this->_uploadFile($value['file']);
                $attributes[$key] = $value;
            }
        }
        return parent::fill($attributes);
    }

    public function save(array $options = [])
    {
        parent::save($options);

        $this->sizeRelations()->delete();
        foreach($this->_sizes as $_value) {
            $this->sizeRelations()->create([
                'album_size_id' => $_value,
            ]);
        }

        $imageIds = [];
        foreach($this->_images as $data) {
            if(!empty($data['id'])) {
                $imageIds[] = $data['id'];
            }
        }
        
        if(!empty($imageIds)) {
            // Remove old images
            $this->images()->whereNotIn('id', $imageIds)->delete();
        }

        foreach($this->_images as $data) {
            if(!empty($data['id'])) {
                $image = \App\Album\Model\LuxeType\Image::find($data['id']);
            } else {
                $image = new \App\Album\Model\LuxeType\Image();
            }
            $data['album_luxe_type_id'] = $this->id;
            $image->fill($data)->save();
        }
        return $this;
    }

    protected function _getSizeIds()
    {
        $values = [];
        foreach($this->sizeRelations as $relation) {
            $values[] = $relation->album_size_id;
        }
        return $values;
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
        $data['images'] = $this->images()->orderBy('sort_order', 'asc')->get();
        $data['sizes'] = $this->hasManyThrough(
            \App\Album\Model\Size::class,
            \App\Album\Model\LuxeTypeSizes::class,
            'album_luxe_type_id', 'id', 'id', 'album_size_id'
        )->orderBy('sort_order', 'asc')->get();

        return $data;
    }

}