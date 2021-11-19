<?php
namespace App\Album\Model;

class AcrylicImage extends VintageCover
{

    const MEDIA_PATH = 'album' . DIRECTORY_SEPARATOR . 'acrylic-images' . DIRECTORY_SEPARATOR;

    protected $table = 'album_acrylic_images';

}