<?php
namespace App\Album\Model\Source;

class Entities extends \WFN\Admin\Model\Source\AbstractSource
{

    protected $entityClass = '';

    protected function _getOptions()
    {
        $options = [];
        if($this->entityClass) {
            foreach($this->entityClass::all() as $cover) {
                $options[$cover->id] = $cover->title;
            }
        }
        return $options;
    }

}