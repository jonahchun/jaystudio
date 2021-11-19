<?php

namespace App\Services\Model\Source\EditRequest;

class Status extends \WFN\Admin\Model\Source\AbstractSource
{

    const SUBMITTED  = 1;
    const PROCESSING = 2;
    const COMPLETE   = 3;

    protected function _getOptions()
    {
        return [
            self::SUBMITTED  => 'Submitted',
            self::PROCESSING => 'Processing',
            self::COMPLETE   => 'Complete',
        ];
    }

}