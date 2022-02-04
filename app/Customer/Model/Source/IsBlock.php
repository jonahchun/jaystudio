<?php

namespace App\Customer\Model\Source;

class IsBlock extends \WFN\Admin\Model\Source\AbstractSource
{

    const YES = 'Yes';
    const NO = 'No';

    protected function _getOptions()
    {
        return [
            self::NO => 'No',
            self::YES => 'Yes',
        ];
    }

}