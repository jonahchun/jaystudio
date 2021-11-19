<?php
namespace App\Album\Block\Admin\BlackMatteCover;

class Grid extends \App\Album\Block\Admin\VintageCover\Grid
{

    protected $adminRoute = 'admin.album.black-matte-cover';

    public function getInstance()
    {
        return new \App\Album\Model\BlackMatteCover();
    }

    public function getTitle()
    {
        return 'Album - Black Matte Covers';
    }

}