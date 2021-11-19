<?php
namespace App\Album\Block\Admin\ArtDecoColor;

class Grid extends \App\Album\Block\Admin\Size\Grid
{

    protected $adminRoute = 'admin.album.art-deco-color';

    public function getInstance()
    {
        return new \App\Album\Model\ArtDecoColor();
    }

    public function getTitle()
    {
        return 'Album - Art Deco Color';
    }

}