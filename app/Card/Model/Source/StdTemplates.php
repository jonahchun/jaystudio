<?php
namespace App\Card\Model\Source;

class StdTemplates extends Templates
{

    protected $card_type = \App\Card\Model\Source\Type::STD;

    protected function _getTemplates()
    {
        return \App\Card\Model\Template::where('card_type', $this->card_type)->get();
    }


}