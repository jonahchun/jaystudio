<?php
namespace App\Core\Model\Source;

class Yesno extends \WFN\Admin\Model\Source\AbstractSource
{

    const YES = 1;
    const NO  = 0;

    protected function _getOptions()
    {
        return [
            self::YES => 'Yes',
            self::NO  => 'No',
        ];
    }

}