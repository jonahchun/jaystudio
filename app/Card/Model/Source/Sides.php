<?php
namespace App\Card\Model\Source;

class Sides extends \WFN\Admin\Model\Source\AbstractSource
{

    const FRONT  = 'front_side';
    const INSIDE = 'inside';
    const BACK   = 'back_side';

    protected function _getOptions()
    {
        return [
            self::FRONT  => 'Front Side',
            self::INSIDE => 'Inside',
            self::BACK   => 'Back Side',
        ];
    }

}