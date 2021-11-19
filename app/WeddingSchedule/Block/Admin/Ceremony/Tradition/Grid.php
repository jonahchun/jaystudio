<?php
namespace App\WeddingSchedule\Block\Admin\Ceremony\Tradition;

class Grid extends \App\WeddingSchedule\Block\Admin\Ceremony\Setting\Grid
{

    protected $adminRoute = 'admin.wedding.schedule.ceremony.tradition';

    public function getInstance()
    {
        return new \App\WeddingSchedule\Model\Ceremony\Tradition();
    }

    public function getTitle()
    {
        return 'Wedding Schedule - Ceremony Traditions';
    }

}