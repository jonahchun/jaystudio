<?php
namespace App\Card\Model\Source;

class Templates extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        $options = [];
        foreach($this->_getTemplates() as $template) {
            $options[$template->id] = $template->title;
        }
        return $options;
    }

    protected function _getTemplates()
    {
        return [];
    }

}