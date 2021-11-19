<?php

namespace App\Customer\Model\Wedding\Schedule\PortraitSession;

use App\Customer\Model\Wedding\Schedule\Address;
use Illuminate\Database\Eloquent\Model;

class PortraitSessionLocation extends Model
{
    const ADDRESS_TYPE = 'portrait_session_location';

    protected $table = 'customer_wedding_schedule_portrait_session_location';

    protected $fillable = ['portrait_session_id	', 'address_id', 'portrait_start_time', 'portrait_end_time', 'name_of_ceremony_portrait'];

    protected $_address_data= [];

    protected $_portrait_session_id = [];

    protected $_schedule_id = [];


    public function getAddressType()
    {
        return static::ADDRESS_TYPE;
    }

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if($key == 'schedule_id'){
                $this->_schedule_id = $value;
                $this->_address_data['schedule_id'] = $this->_schedule_id;
            }
            if($key == 'address') {
                $this->_address_data = $value;
                $this->_address_data['type'] = $this->getAddressType();
            }
            if($key == 'portrait_session_id'){
                $this->_portrait_session_id = $value;
            }
        }
        return parent::fill($attributes);
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['address'] = $this->address;
        return $data;
    }

    public function save(array $options = [])
    {
        $address = $this->address()->create($this->_address_data);
        $this->address_id = $address->id;
        $this->portrait_session_id = $this->_portrait_session_id;
        parent::save();
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }


}