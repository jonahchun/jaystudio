<?php
namespace App\Card\Model\Source;

class SideType extends \WFN\Admin\Model\Source\AbstractSource
{

    const FRONT  = 1;
    const BACK   = 2;
    const INSIDE = 3;

    protected function _getOptions()
    {
        return [
            self::FRONT  => 'Front side',
            self::BACK   => 'Back side',
            self::INSIDE => 'Inside',
        ];
    }

}