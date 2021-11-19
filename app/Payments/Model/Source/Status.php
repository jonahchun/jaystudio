<?php

namespace App\Payments\Model\Source;

class Status extends \WFN\Admin\Model\Source\AbstractSource
{

    const DUE     = 1;
    const PAID    = 2;
    const OVERDUE = 3;

    protected function _getOptions()
    {
        return [
            self::DUE     => 'Due',
            self::PAID    => 'Paid',
            self::OVERDUE => 'Overdue',
        ];
    }

}