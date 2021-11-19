<?php
namespace App\WeddingSchedule\Block\Admin\Preparation\Setting;

class Grid extends \App\WeddingSchedule\Block\Admin\Ceremony\Setting\Grid
{

    protected $adminRoute = 'admin.wedding.schedule.preparation.setting';

    public function getInstance()
    {
        return new \App\WeddingSchedule\Model\Preparation\Setting();
    }

    public function getTitle()
    {
        return 'Wedding Schedule - Preparation Settings';
    }

}