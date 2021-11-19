<?php

namespace App\Services\Model\Source\Upload;

class Status extends \WFN\Admin\Model\Source\AbstractSource
{

    const PENDING_APPROVAL = 1;
    const REJECTED         = 2;
    const APPROVED         = 3;
    const COMPLETED        = 4;

    protected function _getOptions()
    {
        return [
            self::PENDING_APPROVAL => 'Pending Approval',
            self::REJECTED         => 'Rejected',
            self::APPROVED         => 'Approved',
            self::COMPLETED        => 'Completed',
        ];
    }

}