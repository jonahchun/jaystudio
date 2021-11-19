<?php
namespace App\Core\Model\Source;

class FormStep extends \WFN\Admin\Model\Source\AbstractSource
{

    const STEP_ONE   = 1;
    const STEP_TWO   = 2;
    const STEP_THREE = 3;

    protected function _getOptions()
    {
        return [
            self::STEP_ONE   => 'First Step',
            self::STEP_TWO   => 'Second Step',
            self::STEP_THREE => 'Third Step',
        ];
    }

}