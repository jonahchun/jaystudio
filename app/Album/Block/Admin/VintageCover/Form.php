<?php
namespace App\Album\Block\Admin\VintageCover;

class Form extends \App\Core\Block\Admin\BaseForm
{

    protected $adminRoute = 'admin.album.vintage-cover';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'title', 'Title', 'text', ['required' => true]);
        $this->addField('general', 'thumbnail', 'Thumbnail', 'image', [
            'required'    => true,
            'publicValue' => $this->getInstance()->getAttributeUrl('thumbnail')
        ]);
        $this->addField('general', 'sort_order', 'Sort Order', 'text', ['required' => false]);
        return parent::_beforeRender();
    }

}
