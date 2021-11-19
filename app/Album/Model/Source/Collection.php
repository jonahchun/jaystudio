<?php
namespace App\Album\Model\Source;

class Collection extends \WFN\Admin\Model\Source\AbstractSource
{

    const GENUINE_LEATHER = 'genuine_leather';
    const VINTAGE         = 'vintage';
    const BLACK_MATTE     = 'black_matte';
    const ART_DECO        = 'art_deco';

    protected function _getOptions()
    {
        return [
            self::GENUINE_LEATHER => 'Genuine Leather',
            self::VINTAGE         => 'Vintage',
            self::BLACK_MATTE     => 'Black Matte',
            self::ART_DECO        => 'Art Déco',
        ];
    }

    public function getOptionsArray()
    {
        $optionsArray = [];
        foreach($this->_getOptions() as $value => $label) {
            $optionsArray[] = [
                'value' => $value,
                'label' => $label,
                'image' => \Settings::getConfigValueUrl('photo_album/collection_' . $value . '_image'),
            ];
        }
        return $optionsArray;
    }

}