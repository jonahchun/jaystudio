<?php

namespace App\Customer\Model;

use WFN\Customer\Model\Customer\Detail;

class Contact extends Detail
{

    const MEDIA_PATH = 'customer-contatcs' . DIRECTORY_SEPARATOR;

    protected $table = 'customer_contacts';

    protected $mediaFields = ['photo'];

    protected $serviceColumns = ['id', 'created_at', 'updated_at'];

    public function role()
    {
        return $this->hasOne(\App\Customer\Model\Contact\Role::class, 'id', 'role_id');
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['photo_url'] = $this->getAttributeUrl('photo');
        if($this->role) {
            $array['role'] = $this->role->toArray();
        }
        return $array;
    }

}