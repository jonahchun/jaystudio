<?php

namespace App\Customer\Model\Wedding\Schedule;

use Illuminate\Database\Eloquent\Model;

class PortraitSession extends Model
{

    const ADDRESS_TYPE = 'portrait_session';

    protected $table = 'customer_wedding_schedule_portrait_session';

    protected $fillable = ['schedule_id', 'when', 'address_id'];

    protected $_relations = ['portrait_session_location'];

    protected $_portrait_session_locations = [];

    public function getAddressType()
    {
        return static::ADDRESS_TYPE;
    }

    public function getWhenAttribute($value){
        if(is_array(json_decode($value, true)) == false){
            $n_value = [];
            $n_value[0] = $value;
            
            return json_encode($n_value);
        }else{
            return $value;
        }
    }

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if($key == 'portrait_session_location') {
                $this->_portrait_session_locations  = $value;
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

    public function toArray()
    {
        $data = parent::toArray();
        $data['portrait_session_locations'] = $this->portrait_session_locations;
        return $data;
    }
    public function save(array $options = [])
    {
        parent::save();

        if(!empty($this->_portrait_session_locations)) {
            foreach($this->portrait_session_locations as $location) {
                optional($location->address)->delete();
                $location->delete();
            }
        }

        foreach($this->_portrait_session_locations as $location) {
            if(!$location['name_of_ceremony_portrait']) continue;
            $location['portrait_session_id'] = $this->id;
            $location['schedule_id'] = $this->schedule_id;
            PortraitSession\PortraitSessionLocation::create($location);
        }
    }

    public function portrait_session_locations()
    {
        return $this->hasMany(\App\Customer\Model\Wedding\Schedule\PortraitSession\PortraitSessionLocation::class, 'portrait_session_id', 'id');
    }

}