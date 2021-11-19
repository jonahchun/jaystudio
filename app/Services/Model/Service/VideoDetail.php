<?php
namespace App\Services\Model\Service;

class VideoDetail extends PhotoDetail
{

    const MEDIA_PATH = 'service' . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR;

    const TYPE = \App\Services\Model\Source\Type::VIDEO;

}