<?php

namespace App\Customer\Model\Wedding\Schedule;
use App\Core\Model\Traits\HasUploads;

class Reception extends Ceremony
{
    use HasUploads;
    
    const MEDIA_PATH = 'customer-wedding-reception' . DIRECTORY_SEPARATOR;

    const ADDRESS_TYPE = 'reception';

    protected $table = 'customer_wedding_schedule_reception';

    protected $fillable = ['schedule_id', 'address_id',
        'venue_coordinator_name', 'venue_coordinator_email', 'venue_coordinator_phone',
        'viennese_start_time', 'viennese_end_time',
        'cake_cutting_time',
        'reception_start_time', 'reception_end_time',
        'cocktails_start_time', 'cocktails_end_time',
        'afterparty_start_time', 'afterparty_end_time',
        'number_of_toasts', 'toast_givers', 'name_of_reception','timeline_file','insurance_certificate'
    ];

    protected $mediaFields = ['timeline_file'];
    

}