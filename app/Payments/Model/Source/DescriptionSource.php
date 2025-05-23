<?php

namespace App\Payments\Model\Source;

use App\Payments\Model\InvoiceDescription;

class DescriptionSource extends \WFN\Admin\Model\Source\AbstractSource
{
    public $current = null;

    public function _getOptions()
    {
        $data = InvoiceDescription::all()->pluck('name', 'name')->toArray();
        if ($this->current) {
            $exists = array_search($this->current, $data);
            if (!$exists) {
                array_unshift($data, $this->current);
            }
        }
        return $data;
    }

}
