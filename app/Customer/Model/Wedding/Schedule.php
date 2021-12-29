<?php

namespace App\Customer\Model\Wedding;

use App\Core\Model\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    use HasUploads;

    const MEDIA_PATH = 'customer-wedding-schedule' . DIRECTORY_SEPARATOR;
    
    protected $table = 'customer_wedding_schedule';

    protected $fillable = ['availability', 'comment', 'file', 'current_step', 'first_week', 'first_time', 'second_week', 'second_time', 'third_week', 'third_time' ];

    protected $_relations = ['first_newlywed_preparation', 'second_newlywed_preparation',
        'ceremony', 'reception', 'portrait_session','first_newlywed_address','second_newlywed_address'
    ];

    protected $mediaFields = ['file'];

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if(in_array($key, $this->_relations)) {
                $this->setAttribute($key, $value);
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

    public function setAttribute($key, $value)
    {
        if(in_array($key, $this->_relations)) {
            $this->{$key}->fill($value);
            return $this;
        }
        return parent::setAttribute($key, $value);
    }

    public function save(array $options = [])
    {
        parent::save();
        foreach($this->_relations as $relation) {
            if(!$this->{$relation}) {
                continue;
            }
            $this->{$relation}->save();
        }
    }

    public function first_newlywed_preparation()
    {
        return $this->hasOne(\App\Customer\Model\Wedding\Schedule\Preparation::class, 'schedule_id', 'id')
            ->where('type', \App\Customer\Model\Source\NewlywedType::FIRST);
    }

    public function first_newlywed_address()
    {
        return $this->hasOne(\App\Customer\Model\Wedding\Schedule\Address::class, 'schedule_id', 'id')
            ->where('type', \App\Customer\Model\Source\Schedule\AddressType::FIRST_NEWLYWED_PREPARATION);
    }
    public function second_newlywed_address()
    {
        return $this->hasOne(\App\Customer\Model\Wedding\Schedule\Address::class, 'schedule_id', 'id')
            ->where('type', \App\Customer\Model\Source\Schedule\AddressType::SECOND_NEWLYWED_PREPARATION);
    }

    public function second_newlywed_preparation()
    {
        return $this->hasOne(\App\Customer\Model\Wedding\Schedule\Preparation::class, 'schedule_id', 'id')
            ->where('type', \App\Customer\Model\Source\NewlywedType::SECOND);
    }

    public function ceremony()
    {
        return $this->hasOne(\App\Customer\Model\Wedding\Schedule\Ceremony::class, 'schedule_id', 'id');
    }

    public function reception()
    {
        return $this->hasOne(\App\Customer\Model\Wedding\Schedule\Reception::class, 'schedule_id', 'id');
    }

    public function portrait_session()
    {
        return $this->hasOne(\App\Customer\Model\Wedding\Schedule\PortraitSession::class, 'schedule_id', 'id');
    }

    public function createRelations()
    {
        foreach($this->_relations as $relation) {
            if(!$this->{$relation}) {
                $data = [];
                if(strpos($relation, '_newlywed_preparation')) {
                    $data['type'] = str_replace('_newlywed_preparation', '', $relation);
                }
                $this->{$relation}()->create($data);
                $this->load($relation);
                if($relation != 'portrait_session') {
                    $this->{$relation}->address()->create(['type' => $relation]);
                }
            }
        }
    }

    public function getRelations()
    {
        return $this->_relations;
    }

    public function toArray()
    {
        $data = parent::toArray();
        foreach($this->_relations as $relation) {
            if(!$this->{$relation}) {
                $data = [];
                if(strpos($relation, '_newlywed_preparation')) {
                    $data['type'] = str_replace('_newlywed_preparation', '', $relation);
                }
                $this->{$relation}()->create($data);
                $this->load($relation);
            }

            if(!$this->{$relation}->address && method_exists($this->{$relation}, 'address')) {
                $this->{$relation}->address()->create(['type' => $relation]);
                $this->{$relation}->load('address');
            }
            
            $data[$relation] = $this->{$relation};
        }
        $array['file_url'] = $this->getAttributeUrl('file');
        return $data;
    }


}