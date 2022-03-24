<?php

namespace App\Customer\Model\Newlywed;

use App\Core\Model\Traits\HasUploads;

class Detail extends \WFN\Customer\Model\Customer\Detail
{
    use HasUploads;

    const MEDIA_PATH = 'customer-newlywed-details' . DIRECTORY_SEPARATOR;

    protected $table = 'customer_newlywed_details';

    protected $mediaFields = ['file'];

    protected $serviceColumns = ['id', 'created_at', 'updated_at'];

    protected $jsonFields = ['question_answers'];

    public function setAttribute($key, $value)
    {
        if($key == 'question_answers' && is_array($value)) {
            $answers = $this->getAttribute('question_answers');
            foreach($value as $_key => $_value) {
                $answers[$_key] = $_value;
            }
            $value = json_encode($answers);
        }
        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if($key == 'question_answers' && !is_array($value)) {
            $value = json_decode($value, true) ?: [];
        }
        return $value;
    }
    public function save(array $options = [])
    {
        foreach($this->jsonFields as $field) {
            if(empty($this->$field)) {
                $this->$field = '{}';
            } elseif(is_array($this->$field)) {
                $this->$field = json_encode($this->$field);
            }
        }
        return parent::save($options);
    }
}
