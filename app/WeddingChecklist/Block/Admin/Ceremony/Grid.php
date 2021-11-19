<?php
namespace App\WeddingChecklist\Block\Admin\Ceremony;

class Grid extends \App\WeddingChecklist\Block\Admin\Preparation\Grid
{

    protected $adminRoute = 'admin.wedding.checklist.ceremony';

    public function getInstance()
    {
        return new \App\WeddingChecklist\Model\Ceremony();
    }

    public function getTitle()
    {
        return 'Wedding Checklist - Ceremonies';
    }

}