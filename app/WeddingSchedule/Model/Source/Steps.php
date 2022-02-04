<?php

namespace App\WeddingSchedule\Model\Source;

class Steps extends \WFN\Admin\Model\Source\AbstractSource
{

    const PREPARATION      = 'preparation';
    const CEREMONY         = 'ceremony';
    const PORTRAIT_SESSION = 'portrait_session';
    const RECEPTION        = 'reception';

    protected function _getOptions()
    {
        return [
            self::PREPARATION      => 'Preparation',
            self::CEREMONY         => 'Ceremony',
            self::RECEPTION        => 'Reception',
            self::PORTRAIT_SESSION => 'Portrait Session',
        ];
    }
}