<?php
namespace App\Album\Block\Admin\AcrylicImage;

class Grid extends \App\Album\Block\Admin\VintageCover\Grid
{

    protected $adminRoute = 'admin.album.acrylic-images';

    public function getInstance()
    {
        return new \App\Album\Model\AcrylicImage();
    }

    public function getTitle()
    {
        return 'Album - Acrylic Images';
    }

}