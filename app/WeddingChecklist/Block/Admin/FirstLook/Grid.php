<?php
namespace App\WeddingChecklist\Block\Admin\FirstLook;

class Grid extends \App\WeddingChecklist\Block\Admin\Preparation\Grid
{

    protected $adminRoute = 'admin.wedding.checklist.first-look';

    public function getInstance()
    {
        return new \App\WeddingChecklist\Model\FirstLook();
    }

    public function getTitle()
    {
        return 'Wedding Checklist - Portrait Sessions / First Looks';
    }

}