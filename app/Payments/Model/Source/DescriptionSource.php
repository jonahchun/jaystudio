<?php

namespace App\Payments\Model\Source;

use App\Payments\Model\InvoiceDescription;

class DescriptionSource extends \WFN\Admin\Model\Source\AbstractSource
{

    protected function _getOptions()
    {
        return InvoiceDescription::all()->pluck('name', 'name')->toArray();
    }

}
