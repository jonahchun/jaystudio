<?php
namespace App\WeddingSchedule\Block\Admin\Ceremony\Detail;

class Grid extends \App\WeddingSchedule\Block\Admin\Ceremony\Setting\Grid
{

    protected $adminRoute = 'admin.wedding.schedule.ceremony.detail';

    public function getInstance()
    {
        return new \App\WeddingSchedule\Model\Ceremony\Detail();
    }

    public function getTitle()
    {
        return 'Wedding Schedule - Ceremony Details';
    }

}