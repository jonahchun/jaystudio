<?php
namespace App\Album\Model;

class ArtDecoPattern extends VintageCover
{

    const MEDIA_PATH = 'album' . DIRECTORY_SEPARATOR . 'art-deco-pattern' . DIRECTORY_SEPARATOR;

    protected $table = 'album_atr_deco_patterns';

}