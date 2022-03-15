<?php

namespace App\Customer\Model\Wedding;

use App\Core\Model\Traits\HasUploads;

class Checklist extends \WFN\Customer\Model\Customer\Detail
{

    use HasUploads;

    const MEDIA_PATH = 'customer-wedding-checklist' . DIRECTORY_SEPARATOR;

    protected $table = 'customer_wedding_checklist';

    protected $mediaFields = ['file'];

    protected $serviceColumns = ['id', 'created_at', 'updated_at','music_comment'];

    protected $jsonFields = ['preparation', 'ceremony', 'portrait_session', 'reception', 'music', 'vendors'];

    protected $_relations = ['music_songs'];

    protected $_songs_list = false;

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if($key == 'music_songs') {
                $this->_songs_list  = $value;
            }
            if(!empty($this->mediaFields) && in_array($key, $this->mediaFields)) {
                if(!empty($value['file']) && $value['file'] instanceof \Illuminate\Http\UploadedFile) {
                    $value = $this->_uploadFile($value['file']);
                    $attributes[$key] = $value;
                } elseif(strpos($value, 'tmp/') === 0) {
                    $value = $this->_moveFromTmp($value);
                    $attributes[$key] = $value;
                }
            }
        }
        return parent::fill($attributes);
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['file_url'] = $this->getAttributeUrl('file');
        $array['music_songs'] = $this->music_songs;
        return $array;
    }

    public function setAttribute($key, $value)
    {
        if(in_array($key, $this->jsonFields) && is_array($value)) {
            $_values = [];
            foreach($value as $_key => $_value) {
                $_values[$_key] = $_value;
            }
            $value = json_encode($_values);
        }
        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if(in_array($key, $this->jsonFields) && !is_array($value)) {
            $value = json_decode($value, true) ?: [];
        }
        return $value;
    }

    public function getRelations()
    {
        return $this->_relations;
    }

    public function save(array $options = [])
    {
        parent::save();
        foreach($this->jsonFields as $field) {
            if(empty($this->$field)) {
                $this->$field = '{}';
            } elseif(is_array($this->$field)) {
                $this->$field = json_encode($this->$field);
            }
        }

        if($this->_songs_list !== false) {
            foreach($this->music_songs as $list) {
                $list->delete();
            }
    
            foreach($this->_songs_list as $list) {
                if(empty($list['song_name'])) continue;
                $list['checklist_id'] = $this->id;
                Checklist\SongsList::create($list);
            }
        }
    }

    public function music_songs()
    {
        return $this->hasMany(\App\Customer\Model\Wedding\Checklist\SongsList::class, 'checklist_id', 'id');
    }
}