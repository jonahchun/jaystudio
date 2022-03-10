<?php

namespace App\Services\Model\Source;

class Gallery extends \WFN\Admin\Model\Source\AbstractSource
{

    const EDITED      = 'edited_gallery';
    const ORIGINAL    = 'original_gallery';
    const REEDITED    = 're-edited_gallery';
    const REEDITEDV2  = 're-edited_v2_gallery';
    const REEDITEDV3  = 're-edited_v3_gallery';
    const REEDITEDV4  = 're-edited_v4_gallery';

    public function _getOptions()
    {
        return [
            self::EDITED     => 'Edited gallery',
            self::ORIGINAL   => 'Original gallery',
            self::REEDITED   => 'Re-edited gallery',
            self::REEDITEDV2 => 'Re-edited v2 gallery',
            self::REEDITEDV3 => 'Re-edited v3 gallery',
            self::REEDITEDV4 => 'Re-edited v4 gallery',
        ];
    }

}