<?php
namespace App\Card\Model\Source;

class Sizes extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        $options = [];
        foreach(\App\Card\Model\Size::all() as $size) {
            $options[$size->id] = $size->title;
        }
        return $options;
    }

}