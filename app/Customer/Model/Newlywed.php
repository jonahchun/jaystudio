<?php

namespace App\Customer\Model;

use WFN\Customer\Model\Customer\Detail;

class Newlywed extends Detail
{

    const MEDIA_PATH = 'newlywed' . DIRECTORY_SEPARATOR;

    protected $table = 'customer_newlywed';

    protected $mediaFields = ['avatar'];

    protected $fillOriginalNames = false;

    public function isFillable($field)
    {
        if($field == 'type') {
            return true;
        }

        if(strpos($field, '_' . $this->type) !== false) {
            $field = str_replace('_' . $this->type, '', $field);
            return in_array($field, $this->fillable);
        }

        if($this->fillOriginalNames) {
            return parent::isFillable($field);
        }

        return false;
    }

    public function fill(array $attributes)
    {
        $preparedAttributes = [];
        foreach($attributes as $key => $value) {
            if($key == 'type') {
                $preparedAttributes[$key] = $value;
            } elseif(strpos($key, '_' . $this->type) !== false) {
                $key = str_replace('_' . $this->type, '', $key);
                $preparedAttributes[$key] = $value;
            }
        }


        $this->fillOriginalNames = true;
        parent::fill($preparedAttributes);
        $this->fillOriginalNames = false;

        return $this;
    }

    public function getAttribute($key)
    {
        if($key == 'type') {
            return parent::getAttribute($key);
        }

        if($key != 'type' && strpos($key, '_' . $this->type) !== false) {
            $key = str_replace('_' . $this->type, '', $key);
            return parent::getAttribute($key);
        }

        return parent::getAttribute($key);
    }

}
