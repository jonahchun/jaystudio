<?php

namespace App\Customer\Model\Wedding\Schedule;

use Illuminate\Database\Eloquent\Model;
use App\WeddingSchedule\Model\Ceremony\Tradition;

class Ceremony extends Model
{

    const ADDRESS_TYPE = 'ceremony';

    protected $table = 'customer_wedding_schedule_ceremony';

    protected $fillable = ['schedule_id', 'address_id',
        'ceremony_start_time', 'ceremony_end_time',
        'invitation_start_time', 'invitation_end_time',
        'rehearsal_start_time', 'rehearsal_end_time',
        'settings', 'details', 'ceremony_traditions', 'name_of_ceremony'
    ];

    protected $dateFields = [];

    public function address()
    {
        return $this->hasOne(Address::class, 'schedule_id', 'schedule_id')->where('type', $this->getAddressType());
    }

    public function getSettingsLabelAttribute($value)
    {
        $setting = \App\WeddingSchedule\Model\Ceremony\Setting::where('identifier', $this->settings)->first();
        return $setting ? $setting->title : $this->settings;
    }

    public function getDetailLabelsAttribute($value)
    {
        $details = [];
        if(is_array($this->details)) {
            foreach($this->details as $identifier) {
                $detail = \App\WeddingSchedule\Model\Ceremony\Detail::where('identifier', $this->details)->first();
                $details[] = $detail ? $detail->title : $identifier;
            }
        }
        return $details;
    }

    public function getCeremonyTraditionLabelsAttribute($value)
    {
        $traditions = [];
        if(is_array($this->ceremony_traditions)) {
            foreach($this->ceremony_traditions as $identifier) {
                $tradition = \App\WeddingSchedule\Model\Ceremony\Tradition::where('identifier', $identifier)->first();
                $traditions[] = $tradition ? $tradition->title : $identifier;
            }
        }
        return $traditions;
    }

    public function getSettingsAttribute($value)
    {
        $setting = \App\WeddingSchedule\Model\Ceremony\Setting::where('identifier', $value)->first();
        return $setting ? $setting->title : $value;
    }

    public function getAddressType()
    {
        return static::ADDRESS_TYPE;
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['address'] = $this->address;
        foreach($this->dateFields as $field) {
            if($data[$field]) {
                $data[$field] = \Carbon\Carbon::parse($data[$field])->format('m/d/Y');
            }
        }
        $data['ceremony_traditions'] = $this->getAttribute('ceremony_traditions');
        $data['details'] = $this->getAttribute('details');
        return $data;
    }

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if($key == 'address' || $key == 'ceremony_traditions' || $key == 'details') {
                $this->setAttribute($key, $value);
            }
        }
        return parent::fill($attributes);
    }

    public function setAttribute($key, $value)
    {
        if($key == 'address') {
            $this->address->fill($value);
            return $this;
        }
        if(in_array($key, $this->dateFields) && $value) {
            $value = \Carbon\Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        }
        if($key == 'ceremony_traditions' || $key == 'details') {
            $value = json_encode($value);
        }
        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if($key == 'ceremony_traditions' || $key == 'details') {
            $value = json_decode($value, true) ?: [];
        }
        return $value;
    }

    public function save(array $options = [])
    {
        parent::save();
        if($this->address) {
            $this->address->save();
        } else {
            $this->address()->create();
        }
    }

}