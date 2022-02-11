<?php

namespace App\Customer\Model\Wedding\Schedule;

class Preparation extends Ceremony
{

    const ADDRESS_TYPE = '_newlywed_preparation';

    protected $table = 'customer_wedding_schedule_preparation';

    protected $fillable = ['schedule_id', 'type', 'address_id', 'preparation_start_time',
        'preparation_start_date', 'transportation_start_time', 'transportation_start_date',
        'contact_id', 'contact_name', 'contact_phone', 'preparation_id' , 'hair_makeup','jls_start_time','jls_end_time'
    ];

    protected $dateFields = ['preparation_start_date', 'transportation_start_date'];

    public function getAddressType()
    {
        return $this->type . parent::getAddressType();
    }

    public function preparation()
    {
        return $this->belongsTo(\App\WeddingSchedule\Model\Preparation\Setting::class);
    }

    public function contact()
    {
        return $this->belongsTo(\App\Customer\Model\Contact::class);
    }

}