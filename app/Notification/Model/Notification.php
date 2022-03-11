<?php

namespace App\Notification\Model;

use App\Customer\Model\Customer;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const NEW_CUSTOMER_TYPE         = 'new';
    const OLD_CUSTOMER_TYPE         = 'old';
    const FORM_TYPE_1               = 'detail about you';
    const FORM_TYPE_2               = 'schedule';
    const FORM_TYPE_3               = 'checklist';
    const COMMENT_FIELD             = 'Comments';
    const COMMENT_FIELD_TYPE        = 'textarea';
    const FILE_FIELD                = 'File';
    const FILE_FIELD_TYPE           = 'file';
    const NOTIF_MSG_1               = 'has initially complete';

    protected $table = 'notifications';

    protected $serviceColumns = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['form_type','customer_type','customer_id','field_name','old_data','new_data','form_steps','field_type'];


    public function customer()
    {
        return $this->belongsTo(\Customer::class);
    }

}
