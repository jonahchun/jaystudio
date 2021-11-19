<?php
namespace App\Album\Model;

class BlackMatteCover extends VintageCover
{

    const MEDIA_PATH = 'album' . DIRECTORY_SEPARATOR . 'black-matte-covers' . DIRECTORY_SEPARATOR;

    protected $table = 'album_black_matte_covers';

}