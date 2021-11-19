<?php

namespace App\WeddingSchedule\Model\Preparation;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'wedding_schedule_preparation_settings';

    protected $fillable = ['title', 'identifier', 'sort_order'];

}