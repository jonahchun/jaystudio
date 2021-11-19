<?php
namespace App\Card\Model\Source;

class Type extends \WFN\Admin\Model\Source\AbstractSource
{

    const TYC = 1;
    const STD = 2;

    protected function _getOptions()
    {
        return [
            self::TYC => 'Thank you card',
            self::STD => 'Save the Date',
        ];
    }

}