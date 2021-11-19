<?php
namespace App\Album\Model\Source;

class Type extends \WFN\Admin\Model\Source\AbstractSource
{

    const LUXE_TYPE    = 'luxe';
    const ACRYLIC_TYPE = 'acrylic';

    protected function _getOptions()
    {
        return [
            self::LUXE_TYPE    => 'Luxe Album',
            self::ACRYLIC_TYPE => 'Acrylic Album',
        ];
    }

    public function getOptionsArray()
    {
        $optionsArray = [];
        foreach($this->_getOptions() as $value => $label) {
            $optionsArray[] = [
                'value' => $value,
                'label' => $label,
                'image' => \Settings::getConfigValueUrl('photo_album/album_' . $value . '_image'),
            ];
        }
        return $optionsArray;
    }

}