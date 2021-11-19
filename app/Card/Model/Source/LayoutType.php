<?php
namespace App\Card\Model\Source;

class LayoutType extends \WFN\Admin\Model\Source\AbstractSource
{

    const FLAT   = 1;
    const FOLDED = 2;

    protected function _getOptions()
    {
        return [
            self::FLAT   => 'Flat',
            self::FOLDED => 'Folded',
        ];
    }

    public function getOptionsArray()
    {
        $optionsArray = [];
        foreach($this->_getOptions() as $value => $label) {
            $optionsArray[] = [
                'value' => $value,
                'label' => $label,
                'image' => \Settings::getConfigValueUrl('card_type/card_type_' . $value . '_image'),
            ];
        }
        return $optionsArray;
    }

}