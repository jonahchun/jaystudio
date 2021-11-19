<?php

namespace App\WeddingChecklist\Model;

class ChecklistEntities
{

    public static function getEntities()
    {
        return [
            'preparation'      => \App\WeddingChecklist\Model\Preparation::orderBy('sort_order', 'asc')->get(),
            'ceremony'         => \App\WeddingChecklist\Model\Ceremony::orderBy('sort_order', 'asc')->get(),
            'reception'        => \App\WeddingChecklist\Model\Reception::orderBy('sort_order', 'asc')->get(),
            'portrait_session' => \App\WeddingChecklist\Model\FirstLook::orderBy('sort_order', 'asc')->get(),
            'vendors'          => \App\WeddingChecklist\Model\Vendor::orderBy('sort_order', 'asc')->get(),
        ];
    }
}