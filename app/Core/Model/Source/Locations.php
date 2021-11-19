<?php
namespace App\Core\Model\Source;

class Locations extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        $options = [];
        foreach(\App\Core\Model\PickupLocation::all() as $location) {
            $options[$location->id] = $location->title;
        }
        return $options;
    }

}