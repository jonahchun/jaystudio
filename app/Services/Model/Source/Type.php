<?php

namespace App\Services\Model\Source;

class Type extends \WFN\Admin\Model\Source\AbstractSource
{

    const PHOTO       = 'photography';
    const VIDEO       = 'videography';
    const TYC         = 'thank_you_card';
    const STDC        = 'save_the_date_card';
    const PHOTO_ALBUM = 'photo_album';

    protected function _getOptions()
    {
        return [
            self::PHOTO       => 'Photography',
            self::VIDEO       => 'Cinematography',
            self::TYC         => 'Thank You Card',
            self::STDC        => 'Save The Date Card',
            self::PHOTO_ALBUM => 'Photo Album',
        ];
    }

}