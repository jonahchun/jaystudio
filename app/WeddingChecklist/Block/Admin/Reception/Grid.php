<?php
namespace App\WeddingChecklist\Block\Admin\Reception;

class Grid extends \App\WeddingChecklist\Block\Admin\Preparation\Grid
{

    protected $adminRoute = 'admin.wedding.checklist.reception';

    public function getInstance()
    {
        return new \App\WeddingChecklist\Model\Reception();
    }

    public function getTitle()
    {
        return 'Wedding Checklist - Receptions';
    }

}
