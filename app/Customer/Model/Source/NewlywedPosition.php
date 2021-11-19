<?php

namespace App\Customer\Model\Source;

class NewlywedPosition extends \WFN\Admin\Model\Source\AbstractSource
{

    const BRIDE = 'bride';
    const GROOM = 'groom';

    protected function _getOptions()
    {
        return [
            self::BRIDE => 'Bride',
            self::GROOM => 'Groom',
        ];
    }

}