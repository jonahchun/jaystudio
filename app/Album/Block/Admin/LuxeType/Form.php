<?php
namespace App\Album\Block\Admin\LuxeType;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.album.luxe-type';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'title', 'Title', 'text', ['required' => true]);
        $this->addField('general', 'image', 'Image', 'image', ['required' => true]);
        $this->addField('general', 'sizes', 'Sizes', 'multiselect', [
            'required' => true,
            'source'   => \App\Album\Model\Source\Sizes::class
        ]);
        $this->addField('general', 'images', 'Images', 'rows', [
            'columns' => [
                'image' => [
                    'label' => 'Image',
                    'type'  => 'file',
                ],
                'sort_order' => [
                    'label' => 'Sort Order',
                    'type'  => 'text',
                ],
            ],
        ]);
        $this->addField('general', 'sort_order', 'Sort Order', 'text', ['required' => false]);
        return parent::_beforeRender();
    }

}