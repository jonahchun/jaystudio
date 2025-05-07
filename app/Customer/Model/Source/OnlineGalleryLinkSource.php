<?php

namespace App\Customer\Model\Source;

use App\Core\Model\OnlineGalleryLink;

class OnlineGalleryLinkSource extends \WFN\Admin\Model\Source\AbstractSource
{
    protected function _getOptions()
    {
        return OnlineGalleryLink::orderBy('id', 'desc')->get()->pluck('name', 'id')->toArray();
    }

}
