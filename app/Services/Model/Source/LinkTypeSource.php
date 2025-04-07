<?php

namespace App\Services\Model\Source;

use App\Services\Model\ServiceLinkType;

class LinkTypeSource extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        return ServiceLinkType::all()->pluck('name', 'name')->toArray();
    }

}
