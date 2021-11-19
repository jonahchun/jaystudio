<?php

namespace App\Customer\Model\Source;

class NewlywedType extends \WFN\Admin\Model\Source\AbstractSource
{

    const FIRST  = 'first';
    const SECOND = 'second';

    protected function _getOptions()
    {
        return [
            self::FIRST  => 'First',
            self::SECOND => 'Second',
        ];
    }

}