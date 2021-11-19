<?php

namespace App\WeddingChecklist\Model\Source;

class Steps extends \WFN\Admin\Model\Source\AbstractSource
{

    const PREPARATION      = 'preparation';
    const CEREMONY         = 'ceremony';
    const PORTRAIT_SESSION = 'portrait_session';
    const RECEPTION        = 'reception';
    const CINEMATOGRAPHY   = 'cinematography_music';
    const VENDORS          = 'vendors';


    protected function _getOptions()
    {
        return [
            self::PREPARATION      => 'Preparation',
            self::CEREMONY         => 'Ceremony',
            self::PORTRAIT_SESSION => 'Portrait Session/ First Look',
            self::RECEPTION        => 'Reception',
            self::CINEMATOGRAPHY   => 'Cinematography Music',
            self::VENDORS          => 'Vendors',
        ];
    }
}