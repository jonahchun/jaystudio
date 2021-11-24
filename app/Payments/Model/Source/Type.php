<?php

namespace App\Payments\Model\Source;

class Type extends \WFN\Admin\Model\Source\AbstractSource
{

    const PAYPAL  = 1;
    const OFFLINE = 2;

    protected function _getOptions()
    {
        return [
            self::OFFLINE => 'Offline',
            self::PAYPAL  => 'Paypal',
        ];
    }

}