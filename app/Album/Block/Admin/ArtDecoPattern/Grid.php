<?php
namespace App\Album\Block\Admin\ArtDecoPattern;

class Grid extends \App\Album\Block\Admin\VintageCover\Grid
{

    protected $adminRoute = 'admin.album.art-deco-pattern';

    public function getInstance()
    {
        return new \App\Album\Model\ArtDecoPattern();
    }

    public function getTitle()
    {
        return 'Album - Art Deco Patterns';
    }

}