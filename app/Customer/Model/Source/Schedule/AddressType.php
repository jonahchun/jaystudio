<?php

namespace App\Customer\Model\Source\Schedule;

class AddressType extends \WFN\Admin\Model\Source\AbstractSource
{

    const FIRST_NEWLYWED_PREPARATION   = 'first_newlywed_preparation';
    const SECOND_NEWLYWED_PREPARATION  = 'second_newlywed_preparation';
    const CEREMONY                     = 'ceremony';
    const RECEPTION                    = 'reception';
    const PORTRAIT_SESSION             = 'portrait_session';

    protected function _getOptions()
    {
        return [
            self::FIRST_NEWLYWED_PREPARATION  => 'First Newlywed address',
            self::SECOND_NEWLYWED_PREPARATION => 'Second Newlywed Address',
            self::CEREMONY                    => 'Ceremony Address',
            self::RECEPTION                   => 'Reception Address',
            self::PORTRAIT_SESSION            => 'Portrait Session Address',
        ];
    }

}