<?php
namespace App\Card\Model\Source;

class Format extends \WFN\Admin\Model\Source\AbstractSource
{

    const HORIZONTAL = 1;
    const VERTICAL   = 2;

    protected function _getOptions()
    {
        return [
            self::HORIZONTAL => 'Horizontal',
            self::VERTICAL   => 'Vertical',
        ];
    }

}